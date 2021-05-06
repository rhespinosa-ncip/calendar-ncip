<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="surname"><b>SPOUSE'S:</b> </label>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="spouseSurname">SURNAME: </label>
                                <input type="text"class="form-control rounded-0" name="spouseSurname" id="spouseSurname">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="spouseFirstName">FIRST NAME: </label>
                                <input type="text"class="form-control rounded-0" name="spouseFirstName" id="spouseFirstName">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="spouseMiddleName">MIDDLE NAME: </label>
                                <input type="text"class="form-control rounded-0" name="spouseMiddleName" id="spouseMiddleName">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="spouseNameExtension">NAME EXTENSION (JR., SR): </label>
                                <input type="text"class="form-control rounded-0" name="spouseNameExtension" id="spouseNameExtension">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="spouseOccupation">OCCUPATION: </label>
                                <input type="text"class="form-control rounded-0" name="spouseOccupation" id="spouseOccupation">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="spouseEmployerOrBusinessName">EMPLOYER/BUSINESS NAME: </label>
                                <input type="text"class="form-control rounded-0" name="spouseEmployerOrBusinessName" id="spouseEmployerOrBusinessName">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="spouseBusinessAddress">BUSINESS ADDRESS: </label>
                                <input type="text"class="form-control rounded-0" name="spouseBusinessAddress" id="spouseBusinessAddress">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="spouseTelephoneNo">TELEPHONE NO.: </label>
                                <input type="text"class="form-control rounded-0" name="spouseTelephoneNo" id="spouseTelephoneNo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="surname"><b>FATHER'S:</b> </label>
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="fatherSurname">SURNAME: </label>
                        <input type="text"class="form-control rounded-0" name="fatherSurname" id="fatherSurname">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="fatherFirstName">FIRST NAME: </label>
                        <input type="text"class="form-control rounded-0" name="fatherFirstName" id="fatherFirstName">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="fatherMiddleName">MIDDLE NAME: </label>
                        <input type="text"class="form-control rounded-0" name="fatherMiddleName" id="fatherMiddleName">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="fatherExtension">NAME EXTENSION (JR., SR): </label>
                        <input type="text"class="form-control rounded-0" name="fatherExtension" id="fatherExtension">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="surname"><b>MOTHER'S:</b></label>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="motherSurname">SURNAME: </label>
                        <input type="text"class="form-control rounded-0" name="motherSurname" id="motherSurname">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="motherFirstName">FIRST NAME: </label>
                        <input type="text"class="form-control rounded-0" name="motherFirstName" id="motherFirstName">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="motherMiddleName">MIDDLE NAME: </label>
                        <input type="text"class="form-control rounded-0" name="motherMiddleName" id="motherMiddleName">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-12 text-right">
        <button class="btn btn-success rounded-0 btn-add-children-row" table="childrenList">ADD ROW</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered sample-table" id="childrenList">
            <thead>
                <tr>
                    <th>NAME OF CHILDREN  (Write full name and list all)</th>
                    <th>DATE OF BIRTH</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text"class="form-control rounded-0" name="nameOfChildren[]" id="nameOfChildren[]"></td>
                    <td><input type="date"class="form-control rounded-0" name="childrenDateOfBirth[]" id="childrenDateOfBirth[]"></td>
                    <td><button class="btn btn-danger rounded-0 btn-remove-children-row">REMOVE</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
