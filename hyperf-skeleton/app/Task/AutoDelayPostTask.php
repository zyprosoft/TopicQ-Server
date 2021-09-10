<?php


namespace App\Task;

use App\Job\ScrapyImportTopicJob;
use App\Model\Forum;
use App\Model\ManagerAvatarUser;
use App\Model\Post;
use App\Service\Scrapy\PostService;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Str;
use ZYProSoft\Log\Log;

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

    public function isNeedFilter(string $content)
    {
        $search = explode(',',env('REF_FILTER_WORDS'));
        if (Str::contains($content,$search)) {
            return true;
        }
        return false;
    }

    public function execute()
    {
        $sessionHash = env('REF_SESSION_HASH');
        $forumId = Forum::all()->pluck('forum_id')->random();
        $postService = ApplicationContext::getContainer()->get(PostService::class);
        $topicList = $postService->getPostList(0,$sessionHash);
        $list = collect($topicList['list']);
        $postIdList = $list->pluck('topic_id');
        $existPostList = Post::query()->select(['ref_id','title'])->whereIn('ref_id',$postIdList)
            ->get()
            ->keyBy('ref_id');
        for ($index = 0;$index < count($list);$index++) {
            $item = $list[$index];
            $isNeedFilter = $this->isNeedFilter($item['title']);
            if($isNeedFilter) {
                Log::info('敏感标题，不引用:'.$item['title']);
                continue;
            }
            $topicId = $item['topic_id'];
            if (isset($existPostList[$topicId])) {
                Log::info('已经存在此引用'.$topicId);
                continue;
            }
            $post = Post::query()->where('title',$item['title'])->first();
            if($post instanceof Post) {
                $post->ref_id = $topicId;
                $post->save();
                continue;
            }
            //选择一篇转载
            $driverFactory = ApplicationContext::getContainer()->get(DriverFactory::class);
            $driver = $driverFactory->get('default');
            $driver->push(new ScrapyImportTopicJob($topicId,$sessionHash,$forumId));
            Log::info('完成转载选择');
            break;
        }
    }
}