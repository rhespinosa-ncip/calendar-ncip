<?php

namespace App\GlobalClass;

use App\Models\UserPermission;
use DateTime;
use Illuminate\Support\Facades\Auth;

Class SystemLibrary{

    static function timeAgo($date){
        $datetime1 = new DateTime(date('Y-m-d', strtotime($date)));
        $datetime2 = new DateTime(date('Y-m-d'));

        $interval = $datetime2->diff($datetime1);

        $result = $interval->format('%R%a days');

        $status = $datetime1 < $datetime2 ? 'pass' : 'future';

        if($result < 0){
            return array($status, ' '.abs($result).' day(s) ago');
        }else if($result > 0){
            return array($status, '( In '.abs($result).' day(s) )');
        }

        return array($status, ' Today');
    }

    static function previlageInsert($permissionId){
        $previlage = UserPermission::where([['user_id', Auth::id()],['permission_id', $permissionId]])->first();

        $insert = '';

        if(Auth::user()->user_type == 'staff'){
            $insert = isset($previlage->insert) ? ($previlage->insert == 'yes' ? '' : 'd-none') : 'd-none';
        }

        return $insert;
    }
}
