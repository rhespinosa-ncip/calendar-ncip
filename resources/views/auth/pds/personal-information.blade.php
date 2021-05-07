<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="lastName">LASTNAME: </label>
            <input type="text"class="form-control rounded-0" name="lastName" id="lastName" value="{{$data['user']->last_name}}">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="firstName">FIRST NAME: </label>
            <input type="text"class="form-control rounded-0" name="firstName" id="firstName" value="{{$data['user']->first_name}}">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="middleName">MIDDLE NAME: </label>
            <input type="text"class="form-control rounded-0" name="middleName" id="middleName" value="{{$data['user']->middle_name}}">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="nameExtension">NAME EXTENSION (JR., SR): </label>
            <input type="text"class="form-control rounded-0" name="nameExtension" id="nameExtension" value="{{ $data['user']->personalInformation->name_extension  ?? ''}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="dateOfBirth">DATE OF BIRTH: </label>
            <input type="date"class="form-control rounded-0" name="dateOfBirth" id="dateOfBirth" value="{{$data['user']->personalInformation->date_of_birth ?? ''}}">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="placeOfBirth">PLACE OF BIRTH: </label>
            <input type="text"class="form-control rounded-0" name="placeOfBirth" id="placeOfBirth" value="{{$data['user']->personalInformation->place_of_birth ?? ''}}">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="sex">SEX: </label>
            <select class="form-control rounded-0" name="sex" id="sex">
                <option {{isset($data['user']->personalInformation->sex) ? $data['user']->personalInformation->sex == 'male' ? 'selected' : '' : ''}} value="male">Male</option>
                <option {{isset($data['user']->personalInformation->sex) ? $data['user']->sex == 'female' ? 'selected' : '' : ''}} value="female">Female</option>
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="civilStatus">CIVIL STATUS: </label>
            <select class="form-control rounded-0" name="civilStatus" id="civilStatus">
                <option {{isset($data['user']->personalInformation->civil_status) ? $data['user']->personalInformation->civil_status == 'single' ? 'selected' : '' : ''}} value="single">Single</option>
                <option {{isset($data['user']->personalInformation->civil_status) ? $data['user']->personalInformation->civil_status == 'married' ? 'selected' : '' : ''}} value="married">Married</option>
                <option {{isset($data['user']->personalInformation->civil_status) ? $data['user']->personalInformation->civil_status == 'widowed' ? 'selected' : '' : ''}} value="widowed">Widowed</option>
                <option {{isset($data['user']->personalInformation->civil_status) ? $data['user']->personalInformation->civil_status == 'separated' ? 'selected' : '' : ''}} value="separated">Separated</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="height">HEIGHT (m): </label>
            <input type="text"class="form-control rounded-0" name="height" id="height" value="{{$data['user']->personalInformation->height ?? ''}}">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="weight">WEIGHT (kg): </label>
            <input type="text"class="form-control rounded-0" name="weight" id="weight" value="{{$data['user']->personalInformation->weight ?? ''}}">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="bloodType">BLOOD TYPE: </label>
            <select class="form-control rounded-0" name="bloodType" id="bloodType">
                <option {{isset($data['user']->personalInformation->blood_type) ? $data['user']->personalInformation->blood_type == 'a+' ? 'selected' : '' : ''}} value="a+">A+</option>
                <option {{isset($data['user']->personalInformation->blood_type) ? $data['user']->personalInformation->blood_type == 'a-' ? 'selected' : '' : ''}} value="a-">A-</option>
                <option {{isset($data['user']->personalInformation->blood_type) ? $data['user']->personalInformation->blood_type == 'b+' ? 'selected' : '' : ''}} value="b+">B+</option>
                <option {{isset($data['user']->personalInformation->blood_type) ? $data['user']->personalInformation->blood_type == 'b-' ? 'selected' : '' : ''}} value="b-">B-</option>
                <option {{isset($data['user']->personalInformation->blood_type) ? $data['user']->personalInformation->blood_type == 'o+' ? 'selected' : '' : ''}} value="o+">O+</option>
                <option {{isset($data['user']->personalInformation->blood_type) ? $data['user']->personalInformation->blood_type == 'o-' ? 'selected' : '' : ''}} value="o-">O-</option>
                <option {{isset($data['user']->personalInformation->blood_type) ? $data['user']->personalInformation->blood_type == 'ab+' ? 'selected' : '' : ''}} value="ab+">AB+</option>
                <option {{isset($data['user']->personalInformation->blood_type) ? $data['user']->personalInformation->blood_type == 'ab-' ? 'selected' : '' : ''}} value="ab-">AB-</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label for="gsisNo">GSIS ID NO.: </label>
            <input type="text"class="form-control rounded-0 gsis" name="gsisNo" id="gsisNo" value="{{$data['user']->personalInformation->gsis_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="pagibigNo">PAG-IBIG ID NO.: </label>
            <input type="text"class="form-control rounded-0 pagibig" name="pagibigNo" id="pagibigNo" value="{{$data['user']->personalInformation->pag_ibig_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="philhealthNo">PHILHEALTH NO.: </label>
            <input type="text"class="form-control rounded-0 phil-health" name="philhealthNo" id="philhealthNo" value="{{$data['user']->personalInformation->philhealth_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="sssNo">SSS NO.: </label>
            <input type="text"class="form-control rounded-0 sss" name="sssNo" id="sssNo" value="{{$data['user']->personalInformation->sss_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="tinNo">TIN NO.: </label>
            <input type="text"class="form-control rounded-0 tin" name="tinNo" id="tinNo" value="{{$data['user']->personalInformation->tin_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="agencyEmployeeNo">AGENCY EMPLOYEE NO.: </label>
            <input type="text"class="form-control rounded-0" name="agencyEmployeeNo" id="agencyEmployeeNo" value="{{$data['user']->personalInformation->agency_employee_no ?? ''}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="citizenship">CITIZENSHIP: (if holder of dual citizenship, please indicate details) </label>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" {{isset($data['user']->personalInformation->filipino) ? $data['user']->personalInformation->filipino == 'yes' ? 'checked' : '' : ''}} type="checkbox" name="filipino" id="filipino">
                        <label class="form-check-label" for="filipino">Filipino</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" {{isset($data['user']->personalInformation->dual_citizenship) ? $data['user']->personalInformation->dual_citizenship == 'yes' ? 'checked' : '' : ''}} type="checkbox" name="dualCitizenship" id="dualCitizenship">
                        <label class="form-check-label" for="dualCitizenship">Dual Citizenship</label>
                    </div>
                </div>
                <div class="col-lg-4 dual-show d-none">
                    <select class="form-control rounded-0" name="dualCitizenship" id="dualCitizenship">
                        <option value="">-- select dual citizenship--</option>
                        <option value="by_birth">by Birth</option>
                        <option value="by_naturalization">by Naturalization</option>
                    </select>
                </div>
                <div class="col-lg-4 dual-show d-none">
                    <select class="form-control rounded-0" name="country" id="country">
                        @foreach ($data['countries'] as $country)
                            <option {{isset($data['user']->personalInformation->country_id) ? $data['user']->personalInformation->country_id == $country->id ? 'selected' : '' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="height"><b>RESIDENTIAL ADDRESS:</b> </label>
            <div class="row">
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="residentialHouseOrBlockOrLotNo">HOUSE/BLOCK/LOT NO.: </label>
                        <input type="text"class="form-control rounded-0" name="residentialHouseOrBlockOrLotNo" id="residentialHouseOrBlockOrLotNo" value="{{$data['user']->personalInformation->residentialAddress->house_no ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="residentialStreet">STREET: </label>
                        <input type="text"class="form-control rounded-0" name="residentialStreet" id="residentialStreet" value="{{$data['user']->personalInformation->residentialAddress->street ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="residentialSubdivisionOrVillage">SUBDIVISION/VILLAGE: </label>
                        <input type="text"class="form-control rounded-0" name="residentialSubdivisionOrVillage" id="residentialSubdivisionOrVillage" value="{{$data['user']->personalInformation->residentialAddress->subdivision ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="residentialBarangay">BARANGAY: </label>
                        <input type="text"class="form-control rounded-0" name="residentialBarangay" id="residentialBarangay" value="{{$data['user']->personalInformation->residentialAddress->barangay ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="residentialCityOrMunicipal">CITY/MUNICIPAL: </label>
                        <input type="text"class="form-control rounded-0" name="residentialCityOrMunicipal" id="residentialCityOrMunicipal" value="{{$data['user']->personalInformation->residentialAddress->city ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="residentialProvince">PROVINCE: </label>
                        <input type="text"class="form-control rounded-0" name="residentialProvince" id="residentialProvince" value="{{$data['user']->personalInformation->residentialAddress->province ?? ''}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="height"><b>PERMANENT ADDRESS:</b> </label>
            <div class="row">
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="permanentHouseOrBlockOrLotNo">HOUSE/BLOCK/LOT NO.: </label>
                        <input type="text"class="form-control rounded-0" name="permanentHouseOrBlockOrLotNo" id="permanentHouseOrBlockOrLotNo" value="{{$data['user']->personalInformation->permanentAddress->house_no ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="permanentStreet">STREET: </label>
                        <input type="text"class="form-control rounded-0" name="permanentStreet" id="permanentStreet" value="{{$data['user']->personalInformation->permanentAddress->street ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="permanentSubdivisionOrVillage">SUBDIVISION/VILLAGE: </label>
                        <input type="text"class="form-control rounded-0" name="permanentSubdivisionOrVillage" id="permanentSubdivisionOrVillage" value="{{$data['user']->personalInformation->permanentAddress->subdivision ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="permanentBarangay">BARANGAY: </label>
                        <input type="text"class="form-control rounded-0" name="permanentBarangay" id="permanentBarangay" value="{{$data['user']->personalInformation->permanentAddress->barangay ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="permanentCityOrMunicipal">CITY/MUNICIPAL: </label>
                        <input type="text"class="form-control rounded-0" name="permanentCityOrMunicipal" id="permanentCityOrMunicipal" value="{{$data['user']->personalInformation->permanentAddress->city ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="permanentProvince">PROVINCE: </label>
                        <input type="text"class="form-control rounded-0" name="permanentProvince" id="permanentProvince" value="{{$data['user']->personalInformation->permanentAddress->province ?? ''}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="telephoneNo">TELEPHONE NO.: </label>
            <input type="text"class="form-control rounded-0" name="telephoneNo" id="telephoneNo" value="{{$data['user']->personalInformation->telephone_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="mobileNo">MOBILE NO.: </label>
            <input type="text"class="form-control rounded-0" name="mobileNo" id="mobileNo" value="{{$data['user']->personalInformation->mobile_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="emailAddress">E-MAIL ADDRESS(if any): </label>
            <input type="emailAddress"class="form-control rounded-0" name="emailAddress" id="emailAddress" value="{{$data['user']->email}}">
        </div>
    </div>
</div>
