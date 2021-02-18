<form method="POST" accept-charset="UTF-8" id="submitFilter" class="form-modal" enctype="multipart/form-data">
    <input type="hidden" name="filterType" value="{{$data['type'] ?? ''}}">
    <div class="row mt-1">
        <div class="col-6">
            <div class="form-group">
                <label>Date from: </label>
                <input type="date"class="form-control rounded-0" name="dateFrom" id="dateFrom">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Date to: </label>
                <input type="date"class="form-control rounded-0" name="dateTo" id="dateTo">
            </div>
        </div>
    </div>
    @if (Auth::user()->user_type == 'head')
        <div class="row mt-1">
            @if (!isset(Auth::user()->department_id))
                <div class="col-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="bureauDepartment">Division's: </label>
                            <select name="bureauDepartment[]" id="bureauDepartment[]" class="form-control rounded-0" multiple="multiple" style="display: none;">
                                @foreach ($data['bureauDepartment'] as $bureauDepartment)
                                    <option value="{{$bureauDepartment->department->id}}">{{$bureauDepartment->department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="bureauUsers">Bureau user's: </label>
                            <select name="bureauUsers[]" id="bureauUsers[]" class="form-control rounded-0" multiple="multiple" style="display: none;">
                                @foreach ($data['bureauUser'] as $bureauUser)
                                    <option value="{{$bureauUser->id}}">{{$bureauUser->fullName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="departmentUser">User's:</label>
                            <select name="departmentUser[]" User="departmentUser[]" class="form-control rounded-0" multiple="multiple" style="display: none;">
                                @foreach ($data['userPerDepartment'] as $userPerDepartment)
                                    <option value="{{$userPerDepartment->id}}">{{$userPerDepartment->fullName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @elseif(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'executive')
        <div class="row mt-1">
            <div class="col-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="bureauAdmin">Bureau's: </label>
                        <select name="bureauAdmin[]" id="bureauAdmin[]" class="form-control rounded-0" multiple="multiple" style="display: none;">
                            @foreach ($data['bureauAdmin'] as $bureauAdmin)
                                <option value="{{$bureauAdmin->id}}">{{$bureauAdmin->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12 text-right">
             <button form="submitFilter" class="btn btn-success py-1 px-5 rounded-0">FILTER</button>
        </div>
    </div>
 </form>

 <script>
    $("select").bsMultiSelect({
            cssPatch: {
                choices: {
                    columnCount: '1'
                },
            }
    });
</script>
