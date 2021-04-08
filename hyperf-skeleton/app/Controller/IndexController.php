<?php
/**
 * This file is part of ZYProSoft/Hyperf-Skeleton.
 *
 * @link     http://zyprosoft.lulinggushi.com
 * @document http://zyprosoft.lulinggushi.com
 * @contact  1003081775@qq.com
 * @Company  码动未来信息技术有限公司(ZYProSoft)
 * @license  GPL
 */
declare(strict_types=1);
namespace App\Controller;

use ZYProSoft\Controller\AbstractController;
use ZYProSoft\Log\Log;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * @AutoController(prefix="/common/sample")
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends AbstractController
{
    /**
     * 此接口对应访问接口名为
     * common.sample.index
     * @return array
     */
    public function index()
    {
        Log::info("Hello hyperf common demo!");
        $user = $this->request->input('user', 'Hyperf common');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }
}
