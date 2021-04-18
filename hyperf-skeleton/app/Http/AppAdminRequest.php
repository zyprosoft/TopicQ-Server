<?php


namespace App\Http;
use App\Model\User;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Http\AdminRequest;
use ZYProSoft\Log\Log;

class AppAdminRequest extends AdminRequest
{
    protected function isAdmin()
    {
        if (!Auth::isLogin()) {
            return false;
        }
        $user = Auth::user();
        if (!$user instanceof User) {
            return false;
        }
        Log::info("user is admin:".$user->isAdmin());
        return  $user->isAdmin();
    }
}