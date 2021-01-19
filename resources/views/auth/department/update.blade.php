<form method="POST" accept-charset="UTF-8" id="updateDepartment" class="form-modal" enctype="multipart/form-data">
    <input type="hidden" name="departmentId" value="{{$data['department']->id}}">
    <div class="row mt-1">
        <div class="col-12">
            <div class="form-group">
                <label for="departmentName">Division name: </label>
                <input type="text"class="form-control rounded-0" name="departmentName" id="departmentName" value="{{$data['department']->name}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
             <button form="updateDepartment" class="btn btn-success py-1 px-5 rounded-0">UPDATE DIVISION</button>
        </div>
    </div>
 </form>