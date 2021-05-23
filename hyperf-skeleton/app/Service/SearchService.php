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

        //搜索话题
        $topic = Topic::search($keyword)->get();

        //搜索用户
        $user = User::search($keyword)->get();

        return ['post'=>$post,'topic'=>$topic,'user'=>$user];
    }
}