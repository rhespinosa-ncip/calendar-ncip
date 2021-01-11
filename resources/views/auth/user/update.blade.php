<form method="POST" accept-charset="UTF-8" id="updateUser" class="form-modal" enctype="multipart/form-data">
    <input type="hidden" name="userId" value="{{$data['user']->id}}">
    <div class="row mt-1">
        <div class="col-4">
            <div class="form-group">
                <label for="lastName">Last name: </label>
                <input type="text"class="form-control rounded-0" name="lastName" id="lastName" value="{{$data['user']->last_name}}">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="firstName">First name: </label>
                <input type="text"class="form-control rounded-0" name="firstName" id="firstName" value="{{$data['user']->first_name}}">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="middleName">Middle name: </label>
                <input type="text"class="form-control rounded-0" name="middleName" id="middleName" value="{{$data['user']->middle_name}}">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="text"class="form-control rounded-0" name="email" id="email" value="{{$data['user']->email}}">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text"class="form-control rounded-0" name="username" id="username" value="{{$data['user']->username}}">
            </div>
        </div>
        <div class="col-4 d-none">
            <div class="form-group">
                <label for="password">Password: </label>
                <input disabled type="text" value="ncip" class="form-control rounded-0" name="password" id="password">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="position">Position: </label>
                <input type="text" class="form-control rounded-0" name="position" id="position" value="{{$department->position}}">
            </div>
        </div>
        <div class="col-6">
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
             <button form="updateUser" class="btn btn-success py-1 px-5 rounded-0">UPDATE USER</button>
        </div>
    </div>
 </form>
