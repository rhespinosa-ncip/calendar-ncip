<div class="col-12">
    <label for="preparedBy">
        Prepared by: 
    </label>                         
</div>
<div class="col-12">
    <label for="preparedBy">
        {{Auth::user()->fullName}}
    </label>                         
</div>
<div class="col-12">
    <label for="preparedBy">
        (<b>{{Auth::user()->position}}</b>)
    </label>                         
</div>