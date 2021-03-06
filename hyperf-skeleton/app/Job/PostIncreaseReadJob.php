<?php


namespace App\Job;
use App\Service\PostService;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;

class PostIncreaseReadJob extends Job
{
    public int $postId;

    public function __construct(int $postId)
    {
        $this->postId = $postId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $service = ApplicationContext::getContainer()->get(PostService::class);
        $service->increaseRead($this->postId);
    }
}