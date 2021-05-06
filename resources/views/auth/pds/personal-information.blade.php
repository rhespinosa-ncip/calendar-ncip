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
            <input type="text"class="form-control rounded-0" name="nameExtension" id="nameExtension" value="{{$data['user']->personal_information->name_extension ?? ''}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="dateOfBirth">DATE OF BIRTH: </label>
            <input type="date"class="form-control rounded-0" name="dateOfBirth" id="dateOfBirth" value="{{$data['user']->personal_information->date_of_birth ?? ''}}">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="placeOfBirth">PLACE OF BIRTH: </label>
            <input type="text"class="form-control rounded-0" name="placeOfBirth" id="placeOfBirth" value="{{$data['user']->personal_information->place_of_birth ?? ''}}">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="sex">SEX: </label>
            <select class="form-control rounded-0" name="sex" id="sex">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="civilStatus">CIVIL STATUS: </label>
            <select class="form-control rounded-0" name="civilStatus" id="civilStatus">
                <option value="single">Single</option>
                <option value="married">Married</option>
                <option value="widowed">Widowed</option>
                <option value="separated">Separated</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="height">HEIGHT (m): </label>
            <input type="text"class="form-control rounded-0" name="height" id="height" value="{{$data['user']->personal_information->height ?? ''}}">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="weight">WEIGHT (kg): </label>
            <input type="text"class="form-control rounded-0" name="weight" id="weight" value="{{$data['user']->personal_information->weight ?? ''}}">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="bloodType">BLOOD TYPE: </label>
            <select class="form-control rounded-0" name="bloodType" id="bloodType">
                <option value="a+">A+</option>
                <option value="a-">A-</option>
                <option value="b+">B+</option>
                <option value="b-">B-</option>
                <option value="o+">O+</option>
                <option value="o-">O-</option>
                <option value="ab+">AB+</option>
                <option value="ab-">AB-</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label for="gsisNo">GSIS ID NO.: </label>
            <input type="text"class="form-control rounded-0 gsis" name="gsisNo" id="gsisNo" value="{{$data['user']->personal_information->gsis_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="pagibigNo">PAG-IBIG ID NO.: </label>
            <input type="text"class="form-control rounded-0 pagibig" name="pagibigNo" id="pagibigNo" value="{{$data['user']->personal_information->pag_ibig_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="philhealthNo">PHILHEALTH NO.: </label>
            <input type="text"class="form-control rounded-0 phil-health" name="philhealthNo" id="philhealthNo" value="{{$data['user']->personal_information->philhealth_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="sssNo">SSS NO.: </label>
            <input type="text"class="form-control rounded-0 sss" name="sssNo" id="sssNo" value="{{$data['user']->personal_information->sss_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="tinNo">TIN NO.: </label>
            <input type="text"class="form-control rounded-0 tin" name="tinNo" id="tinNo" value="{{$data['user']->personal_information->tin_no ?? ''}}">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="agencyEmployeeNo">AGENCY EMPLOYEE NO.: </label>
            <input type="text"class="form-control rounded-0" name="agencyEmployeeNo" id="agencyEmployeeNo" value="{{$data['user']->personal_information->agency_employee_no ?? ''}}">
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
                        <input class="form-check-input" type="checkbox" id="filipino" value="filipino">
                        <label class="form-check-label" for="filipino">Filipino</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="dualCitizenship" id="dualCitizenship" value="dual_citizenship">
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
                            <option value="{{$country->id}}">{{$country->name}}</option>
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
                        <input type="text"class="form-control rounded-0" name="residentialHouseOrBlockOrLotNo" id="residentialHouseOrBlockOrLotNo" value="{{$data['user']->personal_information->residentialAddress->house_no ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="residentialStreet">STREET: </label>
                        <input type="text"class="form-control rounded-0" name="residentialStreet" id="residentialStreet" value="{{$data['user']->personal_information->residentialAddress->street ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="residentialSubdivisionOrVillage">SUBDIVISION/VILLAGE: </label>
                        <input type="text"class="form-control rounded-0" name="residentialSubdivisionOrVillage" id="residentialSubdivisionOrVillage" value="{{$data['user']->personal_information->residentialAddress->subdivision ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="residentialBarangay">BARANGAY: </label>
                        <input type="text"class="form-control rounded-0" name="residentialBarangay" id="residentialBarangay" value="{{$data['user']->personal_information->residentialAddress->barangay ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="residentialCityOrMunicipal">CITY/MUNICIPAL: </label>
                        <input type="text"class="form-control rounded-0" name="residentialCityOrMunicipal" id="residentialCityOrMunicipal" value="{{$data['user']->personal_information->residentialAddress->city ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="residentialProvince">PROVINCE: </label>
                        <input type="text"class="form-control rounded-0" name="residentialProvince" id="residentialProvince" value="{{$data['user']->personal_information->residentialAddress->province ?? ''}}">
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
                        <input type="text"class="form-control rounded-0" name="permanentHouseOrBlockOrLotNo" id="permanentHouseOrBlockOrLotNo" value="{{$data['user']->personal_information->permanentAddress->house_no ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="permanentStreet">STREET: </label>
                        <input type="text"class="form-control rounded-0" name="permanentStreet" id="permanentStreet" value="{{$data['user']->personal_information->permanentAddress->street ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="permanentSubdivisionOrVillage">SUBDIVISION/VILLAGE: </label>
                        <input type="text"class="form-control rounded-0" name="permanentSubdivisionOrVillage" id="permanentSubdivisionOrVillage" value="{{$data['user']->personal_information->permanentAddress->subdivision ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="permanentBarangay">BARANGAY: </label>
                        <input type="text"class="form-control rounded-0" name="permanentBarangay" id="permanentBarangay" value="{{$data['user']->personal_information->permanentAddress->barangay ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="permanentCityOrMunicipal">CITY/MUNICIPAL: </label>
                        <input type="text"class="form-control rounded-0" name="permanentCityOrMunicipal" id="permanentCityOrMunicipal" value="{{$data['user']->personal_information->permanentAddress->city ?? ''}}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="permanentProvince">PROVINCE: </label>
                        <input type="text"class="form-control rounded-0" name="permanentProvince" id="permanentProvince" value="{{$data['user']->personal_information->permanentAddress->province ?? ''}}">
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
            <input type="text"class="form-control rounded-0" name="telephoneNo" id="telephoneNo">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="mobileNo">MOBILE NO.: </label>
            <input type="text"class="form-control rounded-0" name="mobileNo" id="mobileNo">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="emailAddress">E-MAIL ADDRESS(if any): </label>
            <input type="emailAddress"class="form-control rounded-0" name="emailAddress" id="emailAddress">
        </div>
    </div>
</div>
