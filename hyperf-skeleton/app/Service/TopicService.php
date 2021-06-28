<?php


namespace App\Service;
use App\Constants\Constants;
use App\Job\AddNotificationJob;
use App\Model\Topic;
use App\Model\TopicCategory;
use App\Model\UserAttentionTopic;
use EasyWeChat\Factory;
use Hyperf\Database\Model\Builder;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Service\AbstractService;

class TopicService extends AbstractService
{
    const WX_SECURITY_CHECK_FAIL = 87014;

    public function createCategory(string $name)
    {
        $category = TopicCategory::query()->where('name',$name)->first();
        if ($category instanceof TopicCategory) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $category = new TopicCategory();
        $category->name = $name;
        $category->saveOrFail();
        return $category;
    }

    public function createTopic(array $params)
    {
        //检查用户是不是被拉黑
        UserService::checkUserStatusOrFail();

        $miniProgramConfig = config('weixin.miniProgram');
        $app = Factory::miniProgram($miniProgramConfig);
        $result = $app->content_security->checkText($params['title']);
        $isTitleValidate = true;
        if(data_get($result,'errcode') == self::WX_SECURITY_CHECK_FAIL) {
            $isTitleValidate = false;
        }
        $result = $app->content_security->checkText($params['introduce']);
        $isIntroduceValidate = true;
        if(data_get($result,'errcode') == self::WX_SECURITY_CHECK_FAIL) {
            $isIntroduceValidate = false;
        }
        if($isTitleValidate == false || $isIntroduceValidate == false) {
            //发送一条审核不通过通知
            $levelLabel = '警告';
            $level = Constants::MESSAGE_LEVEL_BLOCK;
            $title = '话题审核不通过';
            if ($isTitleValidate == false) {
                $content = "您的话题标题《{$params['title']}》内容包含敏感信息，已被管理员审核拒绝";
            }else{
                $content = "您的话题导语《{$params['introduce']}》内容包含敏感信息，已被管理员审核拒绝";
            }
            $userId = $this->userId();
            $notification = new AddNotificationJob($userId,$title,$content,false,$level);
            $notification->levelLabel = $levelLabel;
            $this->push($notification);
        }

        if (isset($params['topicId'])) {
            $topic = Topic::findOrFail($params['topicId']);
        }else{
            $topic = Topic::query()->where('title', $params['title'])
                ->first();
            if ($topic instanceof Topic) {
                throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
            }
            $topic = new Topic();
        }
        $topic->introduce = data_get($params,'introduce');
        $topic->image = data_get($params,'image');
        $topic->owner_id = $this->userId();
        $topic->title = data_get($params,'title');
        $topic->circle_id = data_get($params,'circleId');
        if (isset($params['categoryId'])) {
            $topic->category_id = data_get($params,'categoryId');
        }
        //当前用户是不是管理员
        $user = $this->user();
        if($user->role_id > 0) {
            $topic->audit_status = Constants::STATUS_OK;
        }
        $topic->saveOrFail();
        return $topic;
    }

    public function getTopicList(int $pageIndex, int $pageSize, string $keyword = null)
    {
        $list = Topic::query()->where(function (Builder $query) use ($keyword) {
                if (isset($keyword)) {
                    $query->where('title','like',"%$keyword%")
                        ->orWhere('introduce','like',"%$keyword%");
                }
            })->where('audit_status',Constants::STATUS_OK)
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->orderByDesc('sort_index')
            ->orderByDesc('recommend_weight')
            ->latest()
            ->get();
        //补充关注状态
        if (Auth::isGuest() == false){
            $topicIds = $list->pluck('topic_id');
            $attentionList = UserAttentionTopic::query()->where('user_id',$this->userId())
                                                        ->whereIn('topic_id', $topicIds)
                                                        ->get()
                                                        ->keyBy('topic_id');
            $list->map(function (Topic $topic) use ($attentionList) {
                if (!empty($attentionList->get($topic->topic_id))) {
                    $topic->is_attention = 1;
                }else{
                    $topic->is_attention = 0;
                }
                return $topic;
            });
        }else{
             $list->map(function (Topic $topic) {
                $topic->is_attention = 0;
                return $topic;
            });
        }
        $total = Topic::query()->where(function (Builder $query) use ($keyword) {
            if (isset($keyword)) {
                $query->where('title','like',"%$keyword%")
                    ->orWhere('introduce','like',"%$keyword%");
            }
        })->where('audit_status',Constants::STATUS_OK)->count();
        return ['total'=>$total,'list'=>$list];
    }

    public function attention(int $topicId,int $status)
    {
        $attention = UserAttentionTopic::query()->where('user_id', $this->userId())
                                                ->where('topic_id', $topicId)
                                                ->first();
        if($status == Constants::STATUS_DONE && $attention instanceof UserAttentionTopic) {
            throw new HyperfCommonException(\App\Constants\ErrorCode::DO_NOT_REPEAT_ACTION);
        }
        if($status == Constants::STATUS_NOT && !$attention instanceof UserAttentionTopic) {
            throw new HyperfCommonException(\App\Constants\ErrorCode::DO_NOT_REPEAT_ACTION);
        }
        if ($status == Constants::STATUS_DONE) {
            $attention = new UserAttentionTopic();
            $attention->user_id = $this->userId();
            $attention->topic_id = $topicId;
            $attention->saveOrFail();
        }
        if ($status == Constants::STATUS_NOT) {
            $attention->delete();
        }
        return $this->success();
    }

    public function getUserAttentionTopicList(int $pageIndex,int $pageSize)
    {
        $list = UserAttentionTopic::query()->where('user_id',$this->userId())
                                           ->offset($pageIndex * $pageSize)
                                           ->limit($pageSize)
                                           ->latest()
                                           ->get()->pluck('topic');
        $list->map(function (Topic $topic) {
           $topic->is_attention = 1;
           return $topic;
        });
        $total = UserAttentionTopic::query()->where('user_id',$this->userId())->count();
        return ['total'=>$total,'list'=>$list];
    }

    public function getTopicDetail(int $topicId)
    {
        $topic = Topic::findOrFail($topicId);
        if(Auth::isGuest() == false){
            $attention = UserAttentionTopic::query()->where('user_id', $this->userId())
                ->where('topic_id', $topicId)
                ->first();
            if ($attention instanceof UserAttentionTopic) {
                $topic->is_attention = 1;
            }else{
                $topic->is_attention = 0;
            }
        }else{
            $topic->is_attention = 0;
        }

        return $topic;
    }

    public function getTopicAttentionStatus(int $topicId)
    {
        $attention = UserAttentionTopic::query()->where('user_id', $this->userId())
            ->where('topic_id', $topicId)
            ->first();
        if ($attention instanceof UserAttentionTopic) {
            return  ['status' => 1];
        }else{
            return ['status' => 0];
        }
    }
}