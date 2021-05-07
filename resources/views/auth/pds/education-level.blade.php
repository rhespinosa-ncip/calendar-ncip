<div class="row">
    <div class="col-12">
        <table class="table table-bordered sample-table" id="departmentList">
            <thead class="text-center">
                <tr>
                    <th rowspan="2">LEVEL</th>
                    <th rowspan="2">NAME OF SCHOOL</th>
                    <th rowspan="2">BASIC EDUCATION/DEGREE/COURSE</th>
                    <th colspan="2">PERIOD OF ATTENDANCE</th>
                    <th rowspan="2">HIGHEST LEVEL/UNITS EARNED (if not graduated)</th>
                    <th rowspan="2">YEAR GRADUATED</th>
                    <th rowspan="2">SCHOLARSHIP/ ACADEMIC HONORS RECEIVED</th>
                </tr>
                <tr>
                    <th>FROM</th>
                    <th>TO</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $levels = array(
                        'elementary','secondary','vocational/Trade Course','college','graduate Studies'
                    );
                @endphp
                @forelse ($data['user']->educationLevel as $educationLevel)
                    @foreach ($levels as $level)
                        @php
                            $levelTrimmed = str_replace('/', 'Or', str_replace(' ', '', $level));
                        @endphp

                        @if ($levelTrimmed == $educationLevel->level)
                            <tr>
                                <td>
                                    {{strtoupper($level)}}
                                </td>
                                <td>
                                    <input type="text"class="form-control rounded-0" name="{{$levelTrimmed}}NameOfSchool" id="{{$levelTrimmed}}NameOfSchool" value="{{$educationLevel->name_of_school}}">
                                </td>
                                <td>
                                    <input type="text"class="form-control rounded-0" name="{{$levelTrimmed}}BasicEducationOrDegreeOrCourse" id="{{$levelTrimmed}}BasicEducationOrDegreeOrCourse"  value="{{$educationLevel->basic_education}}">
                                </td>
                                <td>
                                    <input type="date"class="form-control rounded-0" name="{{$levelTrimmed}}From" id="{{$levelTrimmed}}From"  value="{{$educationLevel->attendance_from}}">
                                </td>
                                <td>
                                    <input type="date"class="form-control rounded-0" name="{{$levelTrimmed}}To" id="{{$levelTrimmed}}To"  value="{{$educationLevel->attendance_to}}">
                                </td>
                                <td>
                                    <input type="text"class="form-control rounded-0" name="{{$levelTrimmed}}HighestLevelOrUnitEarned" id="{{$levelTrimmed}}HighestLevelOrUnitEarned"  value="{{$educationLevel->highest_level}}">
                                </td>
                                <td>
                                    <input type="text"class="form-control rounded-0" name="{{$levelTrimmed}}YearGraduated" id="{{$levelTrimmed}}YearGraduated"  value="{{$educationLevel->year_graduated}}">
                                </td>
                                <td>
                                    <input type="text"class="form-control rounded-0" name="{{$levelTrimmed}}ScholarshipAcademicHonorRecieved" id="{{$levelTrimmed}}ScholarshipAcademicHonorRecieved"  value="{{$educationLevel->scholarship}}">
                                </td>
                            </tr>
                        @else

                        @endif
                    @endforeach
                @empty
                    @foreach ($levels as $level)
                        @php
                            $levelTrimmed = str_replace('/', 'Or', str_replace(' ', '', $level));
                        @endphp
                        <tr>
                            <td>
                                {{strtoupper($level)}}
                            </td>
                            <td>
                                <input type="text"class="form-control rounded-0" name="{{$levelTrimmed}}NameOfSchool" id="{{$levelTrimmed}}NameOfSchool" value="">
                            </td>
                            <td>
                                <input type="text"class="form-control rounded-0" name="{{$levelTrimmed}}BasicEducationOrDegreeOrCourse" id="{{$levelTrimmed}}BasicEducationOrDegreeOrCourse">
                            </td>
                            <td>
                                <input type="date"class="form-control rounded-0" name="{{$levelTrimmed}}From" id="{{$levelTrimmed}}From">
                            </td>
                            <td>
                                <input type="date"class="form-control rounded-0" name="{{$levelTrimmed}}To" id="{{$levelTrimmed}}To">
                            </td>
                            <td>
                                <input type="text"class="form-control rounded-0" name="{{$levelTrimmed}}HighestLevelOrUnitEarned" id="{{$levelTrimmed}}HighestLevelOrUnitEarned">
                            </td>
                            <td>
                                <input type="text"class="form-control rounded-0" name="{{$levelTrimmed}}YearGraduated" id="{{$levelTrimmed}}YearGraduated">
                            </td>
                            <td>
                                <input type="text"class="form-control rounded-0" name="{{$levelTrimmed}}ScholarshipAcademicHonorRecieved" id="{{$levelTrimmed}}ScholarshipAcademicHonorRecieved">
                            </td>
                        </tr>
                    @endforeach
                @endforelse

            </tbody>
        </table>
    </div>
</div>
