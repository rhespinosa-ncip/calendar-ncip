<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;
use App\Models\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load(storage_path('framework/laravel-excel/pds-template/pds.xlsx'));

        $sheetC1 = $spreadsheet->getActiveSheet('0');
        $this->c1Sheet($sheetC1);

        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");

        $path = storage_path('user-pds/'.Auth::user()->username.'-psd-'.date('dFy').'.xlsx');

        $writer->save($path);

        if (file_exists($path)) {
            return Response::download($path);
        }
    }

    public function c1Sheet($sheetC1){
        $user = User::whereId(Auth::id())->first();

        $sheetC1->setCellValue('D10', $user->last_name);
        $sheetC1->setCellValue('D11', $user->first_name);
        $sheetC1->setCellValue('D12', $user->middle_name);
        $sheetC1->setCellValue('L11', "NAME EXTENSION (JR., SR)    ".PHP_EOL.$user->personalInformation->name_extension);
        $sheetC1->getStyle('L11')->getAlignment()->setWrapText(true);

        $sheetC1->setCellValue('D13', date('m/d/Y',strtotime($user->personalInformation->date_of_birth)));
        $sheetC1->setCellValue('D15', $user->personalInformation->place_of_birth);
        $sheetC1->setCellValue('D22', $user->personalInformation->height);
        $sheetC1->setCellValue('D24', $user->personalInformation->weight);
        $sheetC1->setCellValue('D25', $user->personalInformation->blood_type);

        $sheetC1->setCellValue('D27', $user->personalInformation->gsis_no);
        $sheetC1->setCellValue('D29', $user->personalInformation->pag_ibig_no);
        $sheetC1->setCellValue('D31', $user->personalInformation->philhealth_no);
        $sheetC1->setCellValue('D32', $user->personalInformation->sss_no);
        $sheetC1->setCellValue('D33', $user->personalInformation->tin_no);
        $sheetC1->setCellValue('D34', $user->personalInformation->agency_employee_no);

        $sheetC1->setCellValue('I17', $user->personalInformation->residentialAddress->house_no);
        $sheetC1->setCellValue('L17', $user->personalInformation->residentialAddress->street);
        $sheetC1->setCellValue('I19', $user->personalInformation->residentialAddress->subdivision);
        $sheetC1->setCellValue('L19', $user->personalInformation->residentialAddress->barangay);
        $sheetC1->setCellValue('I22', $user->personalInformation->residentialAddress->city);
        $sheetC1->setCellValue('L22', $user->personalInformation->residentialAddress->province);

        $sheetC1->setCellValue('I25', $user->personalInformation->permanentAddress->house_no);
        $sheetC1->setCellValue('L25', $user->personalInformation->permanentAddress->street);
        $sheetC1->setCellValue('I27', $user->personalInformation->permanentAddress->subdivision);
        $sheetC1->setCellValue('L27', $user->personalInformation->permanentAddress->barangay);
        $sheetC1->setCellValue('I29', $user->personalInformation->permanentAddress->city);
        $sheetC1->setCellValue('L29', $user->personalInformation->permanentAddress->province);

        $sheetC1->setCellValue('I32', $user->personalInformation->telephone_no);
        $sheetC1->setCellValue('I33', $user->personalInformation->mobile_no);
        $sheetC1->setCellValue('I34', $user->email);

        $sheetC1->setCellValue('D36', $user->personalInformation->spouce_surname);
        $sheetC1->setCellValue('D37', $user->personalInformation->spouce_first_name);
        $sheetC1->setCellValue('D38', $user->personalInformation->spouce_middle_name);
        $sheetC1->setCellValue('G37', "NAME EXTENSION (JR., SR)    ".PHP_EOL.$user->personalInformation->spouce_name_extension);
        $sheetC1->getStyle('G37')->getAlignment()->setWrapText(true);
        $sheetC1->setCellValue('D39', $user->personalInformation->spouce_occupation);
        $sheetC1->setCellValue('D40', $user->personalInformation->spouce_employer);
        $sheetC1->setCellValue('D41', $user->personalInformation->spouce_address);
        $sheetC1->setCellValue('D42', $user->personalInformation->spouce_telephone);

        $sheetC1->setCellValue('D43', $user->personalInformation->father_surname);
        $sheetC1->setCellValue('D44', $user->personalInformation->father_first_name);
        $sheetC1->setCellValue('D45', $user->personalInformation->father_middle_name);
        $sheetC1->setCellValue('G44', "NAME EXTENSION (JR., SR)    ".PHP_EOL.$user->personalInformation->father_name_extension);
        $sheetC1->getStyle('G44')->getAlignment()->setWrapText(true);

        $sheetC1->setCellValue('D47', $user->personalInformation->mother_surname);
        $sheetC1->setCellValue('D48', $user->personalInformation->mother_first_name);
        $sheetC1->setCellValue('D49', $user->personalInformation->mother_middle_name);

        $childrenArray = array('37', '38','39','40','41','42','43','44','45','46','47','48');

        $childrenCount = 0;

        foreach($user->personalInformation->children as $children){
            if($childrenCount < 12){
                $sheetC1->setCellValue('I'.$childrenArray[$childrenCount], $children->name);
                $sheetC1->setCellValue('M'.$childrenArray[$childrenCount], date('m/d/Y', strtotime($children->date_of_birth)));
            }

            $childrenCount++;
        }

        $levels = array(
            'elementary','secondary','vocational/Trade Course','college','graduate Studies'
        );

        $educationLevelArray = array('54', '55', '56', '57', '58');

        $educationLevelCount = 0;

        foreach($levels as $level){
            $levelTrimmed = str_replace('/', 'Or', str_replace(' ', '', $level));

            foreach($user->educationLevel as $educationLevel){

                if($levelTrimmed == $educationLevel->level){
                    $sheetC1->setCellValue('D'.$educationLevelArray[$educationLevelCount], $educationLevel->name_of_school);
                    $sheetC1->setCellValue('G'.$educationLevelArray[$educationLevelCount], $educationLevel->basic_education);
                    $sheetC1->setCellValue('J'.$educationLevelArray[$educationLevelCount], $educationLevel->attendance_from);
                    $sheetC1->setCellValue('K'.$educationLevelArray[$educationLevelCount], $educationLevel->attendance_to);
                    $sheetC1->setCellValue('L'.$educationLevelArray[$educationLevelCount], $educationLevel->highest_level);
                    $sheetC1->setCellValue('M'.$educationLevelArray[$educationLevelCount], $educationLevel->year_graduated);
                    $sheetC1->setCellValue('N'.$educationLevelArray[$educationLevelCount], $educationLevel->scholarship);
                }

            }

            $educationLevelCount++;
        }
    }
}
