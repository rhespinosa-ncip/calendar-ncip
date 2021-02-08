@php
    $signatory = App\Models\Signatory::where('user_id', Auth::id())->first();
@endphp
@if ($signatory != null)
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
                    Reviewed by:
                </label>
            </div>
            <div class="col-12">
                <label for="preparedBy">
                    {{$signatory->reviewed_by ?? ''}}
                </label>
            </div>
            <div class="col-12">
                <label for="preparedBy">
                    (<b> {{$signatory->reviewed_by_position ?? ''}}</b>)
                </label>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="row">
            <div class="col-12">
                <label for="preparedBy">
                    Approved by:
                </label>
            </div>
            <div class="col-12">
                <label for="preparedBy">
                    {{$signatory->approved_by ?? ''}}
                </label>
            </div>
            <div class="col-12">
                <label for="preparedBy">
                    (<b> {{$signatory->approved_by_position ?? ''}}</b>)
                </label>
            </div>
        </div>
    </div>
@else
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
                            Approved by:
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
    @elseif(Auth::user()->user_type == 'admin')
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
                            Reviewed by:
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
                            Approved by:
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
                            Approved by:
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
@endif

