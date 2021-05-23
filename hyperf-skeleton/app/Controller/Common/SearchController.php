<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\SearchService;

/**
 * @AutoController (prefix="/common/search")
 * Class SearchController
 * @package App\Controller\Common
 */
class SearchController extends AbstractController
{
    /**
     * @Inject
     * @var SearchService
     */
    protected SearchService $service;

    public function searchAll()
    {
        $this->validate([
            'keyword' => 'string|required|min:1'
        ]);
        $keyword = $this->request->param('keyword');
        $result = $this->service->searchAll($keyword);
        return $this->success($result);
    }
}