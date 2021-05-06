<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'personal_information_id',
        'house_no',
        'street',
        'subdivision',
        'barangay',
        'city',
        'province',
        'type',
    ];

    static function insertUpdate($request, $personalInformation){
        $types = array('residential', 'permanent');

        foreach($types as $type){
            $address = Address::firstOrNew(array('personal_information_id' => $personalInformation->id, 'type' => $type));
            $houseNumber = $type.'HouseOrBlockOrLotNo';
            $street = $type.'Street';
            $subdivision = $type.'SubdivisionOrVillage';
            $barangay = $type.'Barangay';
            $city = $type.'CityOrMunicipal';
            $province = $type.'Province';

            $address->house_no = $request->$houseNumber;
            $address->street = $request->$street;
            $address->subdivision = $request->$subdivision;
            $address->barangay = $request->$barangay;
            $address->city = $request->$city;
            $address->province = $request->$province;
            $address->save();
        }
    }
}

