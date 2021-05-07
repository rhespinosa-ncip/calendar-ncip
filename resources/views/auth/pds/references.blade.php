<div class="row mb-2">
    <div class="col-12 text-right">
        <button class="btn btn-success rounded-0 btn-add-references-row" table="referencesTable">ADD ROW</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered sample-table" id="referencesTable">
            <thead class="text-center">
                <tr>
                    <th>NAME </th>
                    <th>ADDRESS</th>
                    <th>TEL. NO.</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['user']->references as $reference)
                    <tr>
                        <td><input type="text"class="form-control rounded-0" name="referencesName[]" id="referencesName[]" value="{{$reference->name}}"></td>
                        <td><input type="text"class="form-control rounded-0" name="referenceAddress[]" id="referenceAddress[]" value="{{$reference->address}}"></td>
                        <td><input type="text"class="form-control rounded-0" name="referencesTelNo[]" id="referencesTelNo[]" value="{{$reference->telephone_no}}"></td>
                        <td><button class="btn btn-danger rounded-0 btn-remove-references-row">REMOVE</button></td>
                    </tr>
                @empty
                    <tr>
                        <td><input type="text"class="form-control rounded-0" name="referencesName[]" id="referencesName[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="referenceAddress[]" id="referenceAddress[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="referencesTelNo[]" id="referencesTelNo[]"></td>
                        <td><button class="btn btn-danger rounded-0 btn-remove-references-row">REMOVE</button></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
