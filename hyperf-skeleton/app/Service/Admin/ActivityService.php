<?php


namespace App\Service\Admin;
use App\Model\Activity;
use App\Model\Post;
use App\Service\BaseService;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class ActivityService extends BaseService
{
    public function createOrUpdate(array $params)
    {
        $title = data_get($params,'title');
        $introduce = data_get($params,'introduce');
        $image = data_get($params, 'image');
        $postId = data_get($params,'postId',0);
        $jumpPath = data_get($params,'jumpPath');
        $jumpUrl = data_get($params,'jumpUrl');
        $activityId = data_get($params,'activityId');

        if(isset($activityId)) {
            $activity = Activity::firstOrFail($activityId);
        }else{
            $activity = new Activity();
        }
        $activity->title = $title;
        $activity->introduce = $introduce;
        $activity->image = $image;
        $activity->post_id = $postId;
        $activity->jump_path = $jumpPath;
        $activity->jump_url = $jumpUrl;
        $activity->saveOrFail();

        return $this->success();
    }

    public function createOrSyncFromPost(int $postId)
    {
        $activity = Activity::query()->where('post_id',$postId)->first();
        if (!$activity instanceof Activity) {
            $activity = new Activity();
        }
        $post = Post::firstOrFail($postId);
        if (empty($post->image_list)) {
            throw new HyperfCommonException(ErrorCode::PARAM_ERROR,"设置的帖子必须带有图片!");
        }
        $activity->title = $post->title;
        $activity->introduce = $post->summary;
        $activity->image = collect(explode(';',$post->image_list))->first;
        $activity->post_id = $postId;
        $activity->saveOrFail();

        return $this->success();
    }

    public function sort(int $activityId, int $isUp)
    {
        $activity = Activity::firstOrFail($activityId);
        if ($isUp == 1) {
            $activity->increment('sort_index',1);
        }else{
            $activity->decrement('sort_index',1);
        }
    }
}