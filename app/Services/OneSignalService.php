<?php

namespace App\Services;

use App\UserDevice;
use App\Role;
use App\User;
use Ladumor\OneSignal\OneSignal;

class OneSignalService
{
    public static function sendPushToAdmins($message)
    {
        $adminTags = Role::pluck("id")->toArray();

        $userCriteria = function ($query) use ($adminTags) {
            $query->whereIn("role_id", $adminTags);
        };

        $playerIds = UserDevice::with("deviceable")
            ->whereHasMorph('deviceable', [User::class], $userCriteria)
            ->pluck("os_player_id")
            ->toArray();

        $fields['include_player_ids'] = $playerIds;
        OneSignal::sendPush($fields, $message);
    } //end method sendPushToAdmins
}//end  class OneSignalService