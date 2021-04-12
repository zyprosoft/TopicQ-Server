<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\PostIncreaseReadJob;
use App\Model\Post;
use App\Model\ReportPost;
use App\Model\UserFavorite;
use App\Model\UserVote;
use App\Model\Vote;
use App\Model\VoteItem;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Log\Log;

class PostService extends BaseService
{
    public function create(array $params)
    {
        $post = null;
        Db::transaction(function () use ($params, &$post) {
            $title = $params['title'];
            $content = $params['content'];
            $link = data_get($params,'link');
            $imageList = data_get($params,'imageList');
            $vote = data_get($params,'vote');

            $post = new Post();
            $post->owner_id = $this->userId();
            $post->title = $title;
            if (mb_strlen($content) < 32) {
                $post->summary = $content;
            }else{
                $post->summary = mb_substr($content, 0, 32);
            }
            $post->content = $content;
            if (isset($imageList)) {
                $post->image_list = implode(';', $imageList);
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
            }
            $post->saveOrFail();
        });

        if (!isset($post)) {
            throw new HyperfCommonException(ErrorCode::SERVER_ERROR,'发布帖子失败');
        }

        return $this->success($post);
    }

    public function checkOwn(int $postId)
    {
        $post = Post::query()->where('post_id', $postId)
                             ->where('owner_id', $this->userId())
                             ->first();
        if ($post instanceof Post) {
            return $post;
        }
        return  false;
    }

    public function checkOwnOrFail(int $postId)
    {
        $post = $this->checkOwn($postId);
        if ($post === false) {
            throw new HyperfCommonException(ErrorCode::NOT_OWN_BY_CURRENT_USER);
        }
        return $post;
    }

    public function update(int $postId, array $params)
    {
        $post = $this->checkOwnOrFail($postId);
        if (isset($params['title'])) {
            $post->title = $params['title'];
        }
        if (isset($params['imageList'])) {
            $post->image_list = implode(';', $params['imageList']);
        }
        if (isset($params['link'])) {
            $post->link = $params['link'];
        }
        if (isset($params['content'])) {
            $post->content = $params['content'];
        }
        $post->saveOrFail();
        return $this->success();
    }

    public function detail(int $postId)
    {
        $post = Post::query()->where('post_id', $postId)
                             ->with(['vote'])
                             ->first();
        if (!$post instanceof Post) {
            throw new HyperfCommonException(ErrorCode::POST_NOT_EXIST);
        }
        $post->image_list = explode(';',$post->image_list);

        //增加阅读数
        $this->push(new PostIncreaseReadJob($postId));

        return $post;
    }

    public function vote(int $voteItemId, int $postId)
    {
        $userVote = UserVote::query()->where('post_id', $postId)
                                    ->where('user_id', $this->userId())
                                    ->first();
        if ($userVote instanceof UserVote) {
            throw new HyperfCommonException(ErrorCode::DO_NOT_REPEAT_ACTION);
        }
        Db::transaction(function () use ($voteItemId, $postId){
            VoteItem::find($voteItemId)->increment('user_count');
            $userVote = new UserVote();
            $userVote->user_id = $this->userId();
            $userVote->post_id = $postId;
            $userVote->saveOrFail();
        });
        return $this->success();
    }

    public function voteDetail(int $voteId)
    {
        return Vote::query()->where('vote_id', $voteId)
                             ->firstOrFail();
    }

    public function getList(int $sortType, int $pageIndex, int $pageSize)
    {
        $list = Post::query()->where(function (Builder $query) use ($sortType) {
            switch ($sortType) {
                case Constants::POST_SORT_TYPE_LATEST:
                    $query->orderBy('created_at','DESC');
                    break;
                case Constants::POST_SORT_TYPE_LATEST_REPLY:
                    $query->orderBy('last_comment_time','DESC');
                    break;
                case Constants::POST_SORT_TYPE_REPLY_COUNT:
                    $query->orderBy('comment_count','DESC');
                    break;
            }
        })
            ->orderBy('sort_index','DESC')
            ->orderBy('is_hot','DESC')
            ->orderBy('is_recommend','DESC')
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $list->map(function (Post $post) {
            $post->image_list = explode(';',$post->image_list);
            return $post;
        });
        $total = Post::count();
        return ['total'=>$total, 'list'=>$list];
    }

    public function getUserPostList(int $pageIndex, int $pageSize)
    {
        $list = Post::query()->where('owner_id', $this->userId())
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->orderBy('sort_index','DESC')
            ->orderBy('is_hot','DESC')
            ->orderBy('is_recommend','DESC')
            ->latest()
            ->get();
        $list->map(function (Post $post) {
            $post->image_list = explode(';',$post->image_list);
            return $post;
        });
        $total = Post::query()->where('owner_id', $this->userId())
                              ->count();
        return ['total'=>$total, 'list'=>$list];
    }

    public function increaseRead(int $postId)
    {
        Post::query()->where('post_id', $postId)
                     ->increment('read_count');
        return $this->success();
    }

    public function favorite(int $postId)
    {
        $userFavorite = UserFavorite::query()->where('user_id', $this->userId())
                                             ->where('post_id', $postId)
                                             ->first();
        if ($userFavorite instanceof UserFavorite) {
            throw new HyperfCommonException(ErrorCode::DO_NOT_REPEAT_ACTION);
        }
        $userFavorite = new UserFavorite();
        $userFavorite->post_id = $postId;
        $userFavorite->user_id = $this->userId();
        $userFavorite->saveOrFail();
        return $this->success();
    }

    public function reportPost(int $postId, string $content)
    {
        $report = new ReportPost();
        $report->post_id = $postId;
        $report->content = $content;
        $report->owner_id = $this->userId();
        $report->saveOrFail();
        return $this->success();
    }

    public function getUserFavoriteList(int $pageIndex, int $pageSize)
    {
        $list = UserFavorite::query()->where('user_id', $this->userId())
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->orderBy('sort_index','DESC')
            ->orderBy('is_hot','DESC')
            ->orderBy('is_recommend','DESC')
            ->latest()
            ->get();
        $total = UserFavorite::query()->where('user_id', $this->userId())
                                      ->count();
        return ['total'=>$total, 'list'=>$list];
    }
}