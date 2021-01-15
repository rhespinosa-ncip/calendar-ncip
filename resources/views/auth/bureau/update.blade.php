<form method="POST" accept-charset="UTF-8" id="updateBureau" class="form-modal" enctype="multipart/form-data">
    <input type="hidden" name="bureauId" value="{{$data['bureau']->id}}">
    <div class="row mt-1">
        <div class="col-12">
            <div class="form-group">
                <label for="bureauName">Bureau name: </label>
                <input type="text"class="form-control rounded-0" name="bureauName" id="bureauName" value="{{$data['bureau']->name}}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="participant">Division's: </label>
                <select name="department[]" id="department[]" class="form-control rounded-0" multiple="multiple" style="display: none;">
                    @foreach ($data['department'] as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                    @endforeach
                    @foreach ($data['bureauDepartment'] as $bureauDepartment)
                        <option selected value="{{$bureauDepartment->id}}">{{$bureauDepartment->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
             <button form="updateBureau" class="btn btn-success py-1 px-5 rounded-0">UPDATE BUREAU</button>
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
