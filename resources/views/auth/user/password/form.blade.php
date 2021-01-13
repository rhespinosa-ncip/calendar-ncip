<form method="POST" accept-charset="UTF-8" id="changePassword" class="form-modal" enctype="multipart/form-data">
    <div class="row mt-1">
        <div class="col-12">
            <div class="form-group">
                <label for="oldPassword">Old password: </label>
                <input class="form-control rounded-0" type="password" id="oldPassword" name="oldPassword"/>
                <span toggle="#oldPassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="newPassword">New password: </label>
                <input class="form-control rounded-0" type="password" id="newPassword" name="newPassword"/>
                <span toggle="#newPassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
             <button form="changePassword" class="btn btn-success py-1 px-5 rounded-0">CHANGE PASSWORD</button>
        </div>
    </div>
 </form>
