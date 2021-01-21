@if (Auth::user()->user_type == 'head')
    @if (isset(Auth::user()->department_id))
        <div class="col-6">
            <div class="row">
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
            </div>
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <label for="preparedBy">
                        Prepared by:
                    </label>
                </div>
                <div class="col-12">
                    <label for="preparedBy">
                        {{App\Models\User::bureauHead()->fullName ?? ''}}
                    </label>
                </div>
                <div class="col-12">
                    <label for="preparedBy">
                        (<b>{{App\Models\User::bureauHead()->position ?? ''}}</b>)
                    </label>
                </div>
            </div>
        </div>
    @else
        <div class="col-6">
            <div class="row">
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
            </div>
        </div>
    @endif
@else
    @if (isset(Auth::user()->department_id))
        <div class="col-4">
            <div class="row">
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
            </div>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-12">
                    <label for="preparedBy">
                        Prepared by:
                    </label>
                </div>
                <div class="col-12">
                    <label for="preparedBy">
                        {{App\Models\User::departmentHead()->fullName ?? ''}}
                    </label>
                </div>
                <div class="col-12">
                    <label for="preparedBy">
                        (<b> {{App\Models\User::departmentHead()->position ?? ''}}</b>)
                    </label>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-12">
                    <label for="preparedBy">
                        Prepared by:
                    </label>
                </div>
                <div class="col-12">
                    <label for="preparedBy">
                        {{App\Models\User::bureauHead()->fullName ?? ''}}
                    </label>
                </div>
                <div class="col-12">
                    <label for="preparedBy">
                        (<b> {{App\Models\User::bureauHead()->position ?? ''}}</b>)
                    </label>
                </div>
            </div>
        </div>
    @else
        <div class="col-6">
            <div class="row">
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
            </div>
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <label for="preparedBy">
                        Prepared by:
                    </label>
                </div>
                <div class="col-12">
                    <label for="preparedBy">
                        {{App\Models\User::bureauHead()->fullName ?? ''}}
                    </label>
                </div>
                <div class="col-12">
                    <label for="preparedBy">
                        {{App\Models\User::bureauHead()->position ?? ''}}
                    </label>
                </div>
            </div>
        </div>
    @endif
@endif
