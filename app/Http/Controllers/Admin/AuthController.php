<?php

namespace App\Http\Controllers\Admin;

use Adldap\Connections\Ldap;
use Adldap\Laravel\Facades\Adldap;
use App\Core\AdService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Models\User;
use App\Models\UserLoginAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        DB::beginTransaction();
        $credentail = $request->only('username', 'password');
        $user = User::where('username', $credentail['username'])->first();
        if (!$user) {
            return "User not found.";
        }
        if ($user->is_ad) {
            if (!AdService::verifyUserAd($credentail['username'], $credentail['password'])) {
                return "Invalid credentail";
            } else {
                auth()->loginUsingId($user->id);
            }
        }else {
            if (!auth()->attempt($credentail)) {
                return "Invalid credentail";
            }
        }
        $access = UserLoginAccess::generateToken();
        DB::commit();
        return $access;
    }
}
