<?php


namespace App\Service;


use App\Constants\ErrorCode;
use App\Model\Post;
use App\Model\Vote;
use App\Model\VoteItem;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;

class PostService extends BaseService
{
    public function create(array $params)
    {
        $post = null;
        Db::transaction(function () use ($params,&$post) {
            $title = $params['title'];
            $content = $params['content'];
            $link = data_get($params,'link');
            $imageList = data_get($params,'imageList');
            $vote = data_get($params,'vote');

            $post = new Post();
            $post->title = $title;
            if (mb_strlen($content) < 32) {
                $post->summary = $content;
            }
            $post->content = $content;
            if (isset($imageList)) {
                $post->image_list = implode(';',$imageList);
            }
            if (isset($link)) {
                $post->link = $link;
            }

            if (isset($vote)) {
                $subject = $vote['subject'];
                $items = collect($vote['items']);
                $vote = new Vote();
                $vote->title = $subject;
                $vote->saveOrFail();
                $items->map(function (array $item) use ($vote){
                    $voteItem = new VoteItem();
                    $voteItem->content = $item['content'];
                    $voteItem->vote_id = $vote->vote_id;
                    $voteItem->saveOrFail();
                });
                $post->vote_id = $vote->vote_id;
                $post->saveOrFail();
            }
        });

        if (!isset($post)) {
            throw new HyperfCommonException(ErrorCode::SERVER_ERROR,'发布帖子失败');
        }

        return $this->success($post);
    }
}