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
            'userId' => 'integer|required|exists:user,user_id',
            'score' => 'integer|required|min:1|max:200'
        ]);
        $userId = $request->param('userId');
        $score = $request->param('score');
        $result = $this->service->reward($userId,$score);
        return $this->success($result);
    }
}