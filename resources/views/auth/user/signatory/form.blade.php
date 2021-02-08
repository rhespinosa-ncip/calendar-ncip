<form method="POST" accept-charset="UTF-8" id="signatoryForm" class="form-modal" enctype="multipart/form-data">
    <div class="row mt-1">
        <div class="col-12">
            <div class="form-group">
                <label for="reviewedBy">Reviewed by: </label>
                <input class="form-control rounded-0" type="text" id="reviewedBy" name="reviewedBy" value="{{$signatory->reviewed_by ?? ''}}"/>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="reviewedByPosition">Reviewed by position: </label>
                <input class="form-control rounded-0" type="text" id="reviewedByPosition" name="reviewedByPosition" value="{{$signatory->reviewed_by_position ?? ''}}"/>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="approvedBy">Approved by: </label>
                <input class="form-control rounded-0" type="text" id="approvedBy" name="approvedBy" value="{{$signatory->approved_by ?? ''}}"/>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="approvedByPosition">Approved by position: </label>
                <input class="form-control rounded-0" type="text" id="approvedByPosition" name="approvedByPosition" value="{{$signatory->approved_by_position ?? ''}}"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
             <button form="signatoryForm" type="submit" class="btn btn-success py-1 px-5 rounded-0" status="submit">SUBMIT</button>
             @if (isset($signatory))
                <button form="signatoryForm" type="submit" class="btn btn-success py-1 px-5 rounded-0" status="remove">REMOVE</button>
             @endif
        </div>
    </div>
 </form>
