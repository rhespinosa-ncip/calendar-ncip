<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';
    public static $notificationCount = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'personnel',
        'personnel_id',
        'table_id',
        'table_name',
        'link',
    ];

    public function meeting(){
        return $this->hasOne(MeetingSchedule::class, 'id', 'table_id');
    }

    public function actionableItem(){
        return $this->hasOne(ActionableItem::class, 'id', 'table_id');
    }

    public function readNotification(){
        return $this->hasOne(ReadNotification::class, 'notification_id', 'id');
    }


    static function queryNotification($personnel_id, $personnel){
        return Notification::where([['personnel_id', $personnel_id],['personnel', $personnel]]);
    }

    static function queryReadNotification($personnel_id, $personnel){
        return ReadNotification::whereIn('notification_id', $personnel)->where('user_id', $personnel_id);
    }

    static function countNotificationBureau(){
        $perBureau = self::queryNotification(Auth::user()->bureau_id, 'bureau')->get('id');

        if(isset($perBureau)){
            $readNotification = self::queryReadNotification(Auth::id(), $perBureau);
            $totalBureau = count($perBureau) - $readNotification->count();

            self::$notificationCount += $totalBureau;
        }
    }

    static function countNotificationDepartment(){
        $perDepartment = self::queryNotification(Auth::user()->department_id, 'department')->get('id');

        if(isset($perDepartment)){
            $readNotification = self::queryReadNotification(Auth::id(), $perDepartment);
            $totalDepartment = count($perDepartment) - $readNotification->count();

            self::$notificationCount += $totalDepartment;
        }
    }

    static function countNotificationIndividual(){
        $perIndividual = self::queryNotification(Auth::id(), 'individual')->get('id');

        if(isset($perIndividual)){
            $readNotification = self::queryReadNotification(Auth::id(), $perIndividual);
            $totalIndividual = count($perIndividual) - $readNotification->count();

            self::$notificationCount += $totalIndividual;
        }
    }

    static function countNotification(){
        self::countNotificationBureau();
        self::countNotificationDepartment();
        self::countNotificationIndividual();

        return self::$notificationCount;
    }

    static function insert($personnel, $personnel_id, $link, $table_id, $table_name){
        $notification = Notification::create([
            'personnel' => $personnel,
            'personnel_id' => $personnel_id,
            'table_id' => $table_id,
            'table_name' => $table_name,
            'link' => $link,
        ]);
    }
}
