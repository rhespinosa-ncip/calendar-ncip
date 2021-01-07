<form method="POST" accept-charset="UTF-8" id="addUser" class="form-modal" enctype="multipart/form-data">
    <div class="row mt-1">
        <div class="col-4">
            <div class="form-group">
                <label for="lastName">Last name: </label>
                <input type="text"class="form-control rounded-0" name="lastName" id="lastName">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="firstName">First name: </label>
                <input type="text"class="form-control rounded-0" name="firstName" id="firstName">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="middleName">Middle name: </label>
                <input type="text"class="form-control rounded-0" name="middleName" id="middleName">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="text"class="form-control rounded-0" name="email" id="email">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text"class="form-control rounded-0" name="username" id="username">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="password">Password: </label>
                <input disabled type="text" value="ncip" class="form-control rounded-0" name="password" id="password">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="departmentName">Department name: </label>
                <select class="form-control rounded-0" name="departmentName" id="departmentName">
                    @foreach ($data['departments'] as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
             <button form="addUser" class="btn btn-success py-1 px-5 rounded-0">ADD USER</button>
        </div>
    </div>
 </form>