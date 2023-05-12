<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OxygenRolePolicy
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
    }//end constructor method

    public function isAdmin(User $user){
        return $user->role->admin == "OXYGEN_SUPPLIER";
    }//end method isAdmin
}//end class OxygenRolePolicy
