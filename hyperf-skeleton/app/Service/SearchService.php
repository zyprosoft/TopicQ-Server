<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\Forum;
use App\Model\Post;
use App\Model\Topic;
use App\Model\User;
use App\Model\UserAttentionTopic;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;

class SearchService extends BaseService
{
    public function searchAll(string $keyword)
    {
        //搜索帖子
        $post = Post::search($keyword)->get();
        Log::info("searched post info:".json_encode($post));
        $postTotal = $post->count();
        $hasPostMore = 0;
        if ($post->count() > 10) {
            $post = $post->slice(0, 10);
            $hasPostMore = 1;
        }
        $topicIds = $post->pluck('topic_id')->where('topic_id', '>', 0);
        $topicList = Topic::findMany($topicIds)->keyBy('topic_id');
        //过滤仅自己可见的数据
        $post->filter(function (Post $post) {
            return $post->only_self_visible == Constants::STATUS_OK;
        });
        //补充话题
        $post->map(function (Post $post) use ($topicList) {
            if (!empty($post->avatar_list)) {
                $post->avatar_list = explode(';', $post->avatar_list);
            } else {
                $post->avatar_list = null;
            }
            if (!empty($post->image_list)) {
                $post->image_list = explode(';', $post->image_list);
            }
            if ($post->topic_id > 0) {
                $post->topic = $topicList->get($post->topic_id);
            } else {
                $post->topic = null;
            }
            $post->is_read = 0;
            return $post;
        });
        $post = $post->sortByDesc('recommend_weight')->sortByDesc('sort_index')->sortByDesc('comment_count')->values()->all();

        //搜索话题
        $topic = Topic::search($keyword)->get();
        Log::info("searched topic info:".json_encode($topic));
        $topicTotal = $topic->count();
        $hasTopicMore = 0;
        if ($topic->count() > 10) {
            $topic = $topic->slice(0, 10);
            $hasTopicMore = 1;
        }
        //补充关注状态
        if (Auth::isGuest() == false){
            $topicIds = $topic->pluck('topic_id');
            $attentionList = UserAttentionTopic::query()->where('user_id',$this->userId())
                ->whereIn('topic_id', $topicIds)
                ->get()
                ->keyBy('topic_id');
            $topic->map(function (Topic $topic) use ($attentionList) {
                if (!empty($attentionList->get($topic->topic_id))) {
                    $topic->is_attention = 1;
                }else{
                    $topic->is_attention = 0;
                }
                return $topic;
            });
        }else{
            $topic->map(function (Topic $topic) {
                $topic->is_attention = 0;
                return $topic;
            });
        }
        $topic->sortByDesc('recommend_weight')->values()->all();

        //搜索用户
        $user = User::search($keyword)->get();
        Log::info("searched user info:".json_encode($user));
        $userTotal = $user->count();
        $hasUserMore = 0;
        if ($user->count() > 10) {
            $user = $user->slice(0, 10);
            $hasUserMore = 1;
        }

        return ['post' => [
            'total' => $postTotal,
            'list' => $post,
            'has_more' => $hasPostMore
        ], 'topic' => [
            'total' => $topicTotal,
            'list' => $topic,
            'has_more' => $hasTopicMore
        ], 'user' => [
            'total' => $userTotal,
            'list' => $user,
            'has_more' => $hasUserMore
        ]];
    }
}