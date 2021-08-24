<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use  Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\ScoreService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/score")
 * Class ScoreController
 * @package App\Controller\Common
 */
class ScoreController extends AbstractController
{
    /**
     * @Inject
     * @var ScoreService
     */
    protected ScoreService $service;

    public function reward(AuthedRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'score' => 'integer|required|min:1|max:200'
        ]);
        $postId = $request->param('postId');
        $score = $request->param('score');
        $result = $this->service->rewardPost($postId,$score);
        return $this->success($result);
    }
}