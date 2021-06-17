<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\AddNotificationJob;
use App\Model\Topic;
use App\Model\UserAttentionTopic;
use App\Service\BaseService;
use Hyperf\Database\Model\Builder;
use ZYProSoft\Exception\HyperfCommonException;

class TopicService extends BaseService
{
    public function getWaitAuditTopicList(int $pageIndex, int $pageSize, int $lastTopicId = null)
    {
        $list = Topic::query()->where('audit_status',Constants::STATUS_WAIT)
            ->when(isset($lastTopicId),function (Builder $query) use ($lastTopicId) {
                $query->where('topic_id','<', $lastTopicId);
            })
            ->latest()
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        if ($list->isEmpty()) {
            $lastTopicId = 0;
        }else{
            $lastTopicId = $list->last()->topic_id;
        }
        $total = Topic::query()->where('audit_status',Constants::STATUS_WAIT)->count();
        return ['list'=>$list,'total'=>$total,'last_topic_id'=>$lastTopicId];
    }

    public function hiddenTopic(int $isHidden, int $topicId)
    {
        $topic = Topic::findOrFail($topicId);
        $topic->audit_status = $isHidden == 1? Constants::STATUS_HIDDEN:Constants::STATUS_OK;
        $topic->saveOrFail();
        return $this->success();
    }

    public function auditTopic(int $status, int $topicId)
    {
        $topic = Topic::findOrFail($topicId);
        if($topic->audit_status == $status) {
            throw new HyperfCommonException(ErrorCode::DO_NOT_REPEAT_ACTION);
        }
        $topic->audit_status = $status;
        $topic->saveOrFail();
        if ($topic->author->role_id < Constants::USER_ROLE_ADMIN) {
            $title = "发布话题审核结果";
            if($status == Constants::STATUS_OK) {
                $level = Constants::MESSAGE_LEVEL_WARN;
                $content = "您发布的话题《{$topic->title}》已通过管理员审核，感谢您对社区文化构建的大力支持~";
                //用户有没有关注，没有帮助用户自动关注
                $userAttentionTopic = UserAttentionTopic::query()->where('user_id',$topic->owner_id)
                    ->where('topic_id',$topic->topic_id)
                    ->first();
                if (!$userAttentionTopic instanceof UserAttentionTopic) {
                    $userAttentionTopic = new UserAttentionTopic();
                    $userAttentionTopic->user_id = $topic->owner_id;
                    $userAttentionTopic->topic_id = $topic->topic_id;
                    $userAttentionTopic->saveOrFail();
                }
                $levelLabel = "通知";
            }else{
                $levelLabel = "提醒";
                $level = Constants::MESSAGE_LEVEL_BLOCK;
                $content = "很遗憾，您发布的话题《{$topic->title}》未通过管理员审核，仍然感谢您对社区文化构建的积极参与~";
            }
            $notification = new AddNotificationJob($topic->owner_id,$title,$content,false,$level,$levelLabel);
            $this->push($notification);
        }
        return $this->success();
    }

    public function getTopicList(int $pageIndex, int $pageSize)
    {
        $list = Topic::query()->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->orderByDesc('sort_index')
            ->orderByDesc('recommend_weight')
            ->latest()
            ->get();
        $total = Topic::count();
        return ['total'=>$total,'list'=>$list];
    }

    public function getMaxRecommendWeight()
    {
        return Topic::query()->max('recommend_weight');
    }

    public function updateRecommendWeight(int $topicId, int $weight)
    {
        $topic = Topic::findOrFail($topicId);
        $topic->recommend_weight = $weight;
        $topic->saveOrFail();
    }
}