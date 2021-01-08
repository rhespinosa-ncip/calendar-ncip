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

    static function day(){
        $hour = date('H', time());

        if( $hour > 6 && $hour <= 11) {
            return "Good morning";
        }
        else if($hour > 11 && $hour <= 16) {
            return "Good afternoon";
        }
        else if($hour > 16 && $hour <= 23) {
            return "Good evening";
        }
    }
}
