<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //第一个参数代表当前登录用户，第二个代表授权的用户
    public function update(User $currentUser,User $user)
    {
        return $currentUser->id === $user->id;
    }
}
