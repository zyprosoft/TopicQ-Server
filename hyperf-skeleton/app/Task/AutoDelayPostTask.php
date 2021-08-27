<?php


namespace App\Task;


use App\Constants\Constants;
use App\Model\DelayPostTask;
use App\Model\ManagerAvatarUser;
use App\Model\Scrapy\Post;
use App\Model\Scrapy\Thread;
use App\Model\User;
use Hyperf\DbConnection\Db;

class AutoDelayPostTask
{
    protected function trimString(string $content = null)
    {
        if (empty($content)) {
            return $content;
        }
        $chars = [" ", "　", "\t", "\n", "\r"];
        return str_replace($chars, "", $content);
    }

    protected function getRandomUser()
    {
        //获取随机用户
        $max = ManagerAvatarUser::count()-1;
        $random = rand(0,$max);
        return ManagerAvatarUser::query()->offset($random)
            ->limit(1)
            ->firstOrFail();
    }

    public function execute()
    {
        Db::transaction(function (){
            //拉取任务进行执行
            $task = DelayPostTask::query()->where('status',Constants::STATUS_NOT)
                ->limit(1)
                ->firstOrFail();
            if (!$task instanceof DelayPostTask) {
                return;
            }
            $post = Thread::query()->where('id',$task->post_id)
                ->with(['floor'])
                ->firstOrFail();
            if(!$post instanceof Thread) {
                return;
            }

            $insertPost = new \App\Model\Post();
            $insertPost->title = $post->title;
            $insertPost->owner_id = $this->getRandomUser()->avatar_user_id;
            if(!empty($post->floor())) {
                $contentFloor = $post->floor()->first();

                //概要
                $postContent = $contentFloor->content;
                if ($contentFloor->content == $post->title) {
                    $insertPost->summary = "如题";
                    $postContent = "如题";
                }

                if (mb_strlen($contentFloor->content) > 40) {
                    $summary = mb_substr($contentFloor->content, 0, 40);
                    $summary = $this->trimString($summary);
                    $insertPost->summary = $summary;
                }
                //内容
                $insertPost->rich_content = json_encode([[
                    'type' => 'text',
                    'type_name' => '文本',
                    'content' => $postContent,
                    'is_bold' => 0,
                    'font_size' => 14,
                    'display_font_size' => 32,
                    'font_size_name' => 'lg',
                    'text_color' => 'black'
                ]]);
            }else{
                $insertPost->summary = "如题";
                //内容
                $insertPost->rich_content = json_encode([[
                    'type' => 'text',
                    'type_name' => '文本',
                    'content' => "如题",
                    'is_bold' => 0,
                    'font_size' => 14,
                    'display_font_size' => 32,
                    'font_size_name' => 'lg',
                    'text_color' => 'black'
                ]]);
            }
            //转帖子
            if($task->is_active == Constants::STATUS_NOT) {
                $insertPost->forum_id = $task->forum_id;
            }else{
                $insertPost->circle_id = $task->circle_id;
            }
            $task->status = Constants::STATUS_OK;
            $task->saveOrFail();
            $insertPost->saveOrFail();
        });
    }
}