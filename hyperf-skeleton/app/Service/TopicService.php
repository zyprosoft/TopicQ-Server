<?php


namespace App\Service;
use App\Constants\Constants;
use App\Job\AddNotificationJob;
use App\Model\Topic;
use App\Model\TopicCategory;
use EasyWeChat\Factory;
use Hyperf\Database\Model\Builder;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;
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

        $topic = Topic::query()->where('title', $params['title'])
                               ->first();
        if ($topic instanceof Topic) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $topic = new Topic();
        $topic->introduce = data_get($params,'introduce');
        $topic->image = data_get($params,'image');
        $topic->owner_id = $this->userId();
        $topic->category_id = data_get($params,'categoryId');
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
            })->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = Topic::query()->where(function (Builder $query) use ($keyword) {
            if (isset($keyword)) {
                $query->where('title','like',"%$keyword%")
                    ->orWhere('introduce','like',"%$keyword%");
            }
        })->count();
        return ['total'=>$total,'list'=>$list];
    }
}