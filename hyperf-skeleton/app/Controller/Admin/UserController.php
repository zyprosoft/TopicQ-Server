<?php


namespace App\Controller\Admin;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\UserService;

/**
 * @AutoController (prefix="/admin/user")
 * Class UserController
 * @package App\Controller\Admin
 */
class UserController extends AbstractController
{
    /**
     * @Inject
     * @var UserService
     */
    private UserService $service;

    public function login()
    {
        $this->validate([
            'username' => 'string|min:1|required',
            'password' => 'string|min:1|required'
        ]);
        $username = $this->request->param('username');
        $password = $this->request->param('password');
        $result = $this->service->login($username, $password);
        return $this->success($result);
    }
}