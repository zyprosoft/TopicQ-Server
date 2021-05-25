<?php


namespace App\Service;


use App\Model\Post;
use App\Model\Topic;
use App\Model\User;

class SearchService extends BaseService
{
    public function searchAll(string $keyword)
    {
        //搜索帖子
        $post = Post::search($keyword)->get();
        $hasPostMore = 0;
        if ($post->count() > 10) {
            $post = $post->slice(0,10);
            $hasPostMore = 1;
        }

        //搜索话题
        $topic = Topic::search($keyword)->get();
        $hasTopicMore = 0;
        if ($topic->count() > 10) {
            $topic = $topic->slice(0,10);
            $hasTopicMore = 1;
        }

        //搜索用户
        $user = User::search($keyword)->get();
        $hasUserMore = 0;
        if ($user->count() > 10) {
            $user = $user->slice(0,10);
            $hasUserMore = 1;
        }

        return ['post'=>[
            'list' => $post,
            'has_more' => $hasPostMore
        ],'topic'=>[
            'list' => $topic,
            'has_more' => $hasTopicMore
        ],'user'=>[
            'list' => $user,
            'has_more' => $hasUserMore
        ]];
    }
}