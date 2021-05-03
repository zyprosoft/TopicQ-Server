<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\PddService;

/**
 * @AutoController (prefix="/common/mall")
 * Class MallController
 * @package App\Controller\Common
 */
class MallController extends AbstractController
{
    /**
     * @Inject
     * @var PddService
     */
    protected PddService $pddService;

    public function generatePddApplyUrl()
    {

    }
}