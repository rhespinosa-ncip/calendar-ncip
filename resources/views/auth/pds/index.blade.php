@extends('index.main')

@push('style')
    <style>
        .tab-content{
            background: #f8fafc;
        }
    </style>
@endpush

@section('auth-content')
    <div class="container-fluid mb-5 mt-3">
        <div class="card rounded-0">
            <div class="card-body">
                <form id="updatePDS">
                    <div class="row">
                        <div class="col-12 text-right">
                            <a class="btn btn-success rounded-0"  target="_blank" href="/pds/export">EXPORT</a>
                            <button class="btn btn-success rounded-0 update-button btn-update">UPDATE</button>
                            <button class="btn btn-success rounded-0 save-button d-none" form="updatePDS">SAVE</button>
                        </div>
                    </div>
                    <nav>
                        <div class="nav nav-tabs" role="tablist">
                            <a class="nav-item nav-link active" data-toggle="tab" href="#personalInfoTab" role="tab" aria-selected="false">
                                Personal Information
                            </a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#familyBackgroundTab" role="tab" aria-selected="false">
                                Family Background
                            </a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#educationLevelTab" role="tab" aria-selected="false">
                                Education Level
                            </a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#civilServiceEligibilityTab" role="tab" aria-selected="false">
                                Civil Service Eligibility
                            </a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#workExperienceTab" role="tab" aria-selected="false">
                                Work Experience
                            </a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#voluntaryWorkTab" role="tab" aria-selected="false">
                                Voluntary Work or Involvement
                            </a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#learningAndDevelopmentTab" role="tab" aria-selected="false">
                                Learning and Development
                            </a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#otherInformationTab" role="tab" aria-selected="false">
                                Other Information
                            </a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#questionsTab" role="tab" aria-selected="false">
                                Questions
                            </a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#referencesTab" role="tab" aria-selected="false">
                                References
                            </a>
                        </div>
                    </nav>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="personalInfoTab" role="tabpanel">
                            @include('auth.pds.personal-information')
                        </div>
                        <div class="tab-pane fade" id="familyBackgroundTab" role="tabpanel">
                            @include('auth.pds.family-background')
                        </div>
                        <div class="tab-pane fade" id="educationLevelTab" role="tabpanel">
                            @include('auth.pds.education-level')
                        </div>
                        <div class="tab-pane fade" id="civilServiceEligibilityTab" role="tabpanel">
                            @include('auth.pds.civil-service')
                        </div>
                        <div class="tab-pane fade" id="workExperienceTab" role="tabpanel">
                            @include('auth.pds.work-experience')
                        </div>
                        <div class="tab-pane fade" id="voluntaryWorkTab" role="tabpanel">
                            @include('auth.pds.voluntary-work')
                        </div>
                        <div class="tab-pane fade" id="learningAndDevelopmentTab" role="tabpanel">
                            @include('auth.pds.learning-development')
                        </div>
                        <div class="tab-pane fade" id="otherInformationTab" role="tabpanel">
                            @include('auth.pds.other-information')
                        </div>
                        <div class="tab-pane fade" id="questionsTab" role="tabpanel">
                            @include('auth.pds.questions')
                        </div>
                        <div class="tab-pane fade" id="referencesTab" role="tabpanel">
                            @include('auth.pds.references')
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('js/pds/form.js')}}"></script>
@endpush
