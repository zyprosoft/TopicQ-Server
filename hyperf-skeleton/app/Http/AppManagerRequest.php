<?php


namespace App\Http;
use App\Constants\Constants;
use App\Model\User;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Http\AdminRequest;
use ZYProSoft\Log\Log;

class AppManagerRequest extends AdminRequest
{
    public function isAdmin()
    {
        if (!Auth::isLogin()) {
            return false;
        }
        $user = Auth::user();
        if (!$user instanceof User) {
            return false;
        }
        Log::info("user is manager:".$user->role_id);
        return  $user->role_id >= Constants::USER_ROLE_ADMIN;
    }
}