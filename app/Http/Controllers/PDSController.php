<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;
use App\Models\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PDSController extends Controller
{

    public function index(Request $request){
        $data = array(
            'user' => User::whereId(Auth::id())->first(),
            'countries' => Country::all(),
        );

        return view('auth.pds.index', compact('data'));
    }

    public function update(Request $request){
        $validate = Validator::make($request->all(), $this->rule());

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages()
            ]);
        }

        $personalInformation = PersonalInformation::insertUpdate($request);

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function rule(){
        return [
            'lastName' => 'required',
            'firstName' => 'required',
            'dateOfBirth' => 'required',
            'placeOfBirth' => 'required',
            'sex' => 'required',
            'civilStatus' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'bloodType' => 'required',
            'mobileNo' => 'required',
            'residentialHouseOrBlockOrLotNo' => 'required',
            'residentialStreet' => 'required',
            'residentialSubdivisionOrVillage' => 'required',
            'residentialBarangay' => 'required',
            'residentialCityOrMunicipal' => 'required',
            'residentialProvince' => 'required',
            'permanentHouseOrBlockOrLotNo' => 'required',
            'permanentStreet' => 'required',
            'permanentSubdivisionOrVillage' => 'required',
            'permanentBarangay' => 'required',
            'permanentCityOrMunicipal' => 'required',
            'permanentProvince' => 'required',
        ];
    }

    public function export(){
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load(storage_path('framework/laravel-excel/pds-template/pds.xlsx'));
            
        $sheetC1 = $spreadsheet->getActiveSheet('0');
        $sheetC1->setCellValue('D10', 'PUTA!');
        $spreadsheet->save();

        $writer = new Xlsx($spreadsheet);
        $writer->save('yourFileHere.xlsx');
    }    
}
