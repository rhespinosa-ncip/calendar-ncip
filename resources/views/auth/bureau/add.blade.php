<form method="POST" accept-charset="UTF-8" id="addBureau" class="form-modal" enctype="multipart/form-data">
    <div class="row mt-1">
        <div class="col-12">
            <div class="form-group">
                <label for="bureauName">Bureau name: </label>
                <input type="text"class="form-control rounded-0" name="bureauName" id="bureauName">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="participant">Division's: </label>
                <select name="department[]" id="department[]" class="form-control rounded-0" multiple="multiple" style="display: none;">
                    @foreach ($data['department'] as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
             <button form="addBureau" class="btn btn-success py-1 px-5 rounded-0">ADD BUREAU</button>
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
