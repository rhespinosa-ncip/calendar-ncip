<div class="row">
    <div class="col-12">
        <table class="table table-borderless sample-table" id="questionTable">
            <tbody>
                <tr class="d-flex">
                    <td class="col-6">Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be apppointed,</td>
                </tr>
                @foreach ($data['user']->questions as $question)
                    @php
                        switch ($question->question) {
                            case 'questionQ1A':
                                    $answer1A = $question->answer;
                                    $answer1AYes = $question->if_yes;
                                break;
                            case 'questionQ1B':
                                    $answer1B = $question->answer;
                                    $answer1BYes = $question->if_yes;
                                break;
                            case 'questionQ2A':
                                    $answer2A = $question->answer;
                                    $answer2AYes = $question->if_yes;
                                break;
                            case 'questionQ2B':
                                    $answer2B = $question->answer;
                                    $answer2BYes = $question->if_yes;
                                break;
                            case 'questionQ3A':
                                    $answer3A = $question->answer;
                                    $answer3AYes = $question->if_yes;
                                break;
                            case 'questionQ4A':
                                    $answer4A = $question->answer;
                                    $answer4AYes = $question->if_yes;
                                break;
                            case 'questionQ5A':
                                    $answer5A = $question->answer;
                                    $answer5AYes = $question->if_yes;
                                break;
                            case 'questionQ5B':
                                    $answer5B = $question->answer;
                                    $answer5BYes = $question->if_yes;
                                break;
                            case 'questionQ6A':
                                    $answer6A = $question->answer;
                                    $answer6AYes = $question->if_yes;
                                break;
                            case 'questionQ7A':
                                    $answer7A = $question->answer;
                                    $answer7AYes = $question->if_yes;
                                break;
                            case 'questionQ7B':
                                    $answer7B = $question->answer;
                                    $answer7BYes = $question->if_yes;
                                break;
                            case 'questionQ7C':
                                    $answer7C = $question->answer;
                                    $answer7CYes = $question->if_yes;
                                break;
                            default:
                                # code...
                                break;
                        }
                    @endphp
                @endforeach
                <tr class="d-flex">
                    <td class="col-6">a. within the third degree?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ1A" id="answerQ1A">
                            <option {{$answer1A == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer1A == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ1A" id="yesAnswerQ1A" placeholder="if yes, give details" value="{{$answer1AYes}}"></td>
                </tr>
                <tr class="d-flex">
                    <td class="col-6">b. within the fourth degree (for Local Government Unit - Career Employees)?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ1B" id="answerQ1B">
                            <option {{$answer1B == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer1B == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ1B" id="yesAnswerQ1B" placeholder="if yes, give details" value="{{$answer1BYes}}"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <table class="table table-borderless sample-table" id="questionTable">
            <tbody>
                <tr class="d-flex">
                    <td class="col-6">a. Have you ever been found guilty of any administrative offense?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ2A" id="answerQ2A">
                            <option {{$answer2A == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer2A == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ2A" id="yesAnswerQ2A" placeholder="if yes, give details" value="{{$answer2AYes}}"></td>
                </tr>
                <tr class="d-flex">
                    <td class="col-6">b. Have you been criminally charged before any court?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ2B" id="answerQ2B">
                            <option {{$answer2B == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer2B == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ2B" id="yesAnswerQ2B" placeholder="if yes, give details" value="{{$answer2BYes}}"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <table class="table table-borderless sample-table" id="questionTable">
            <tbody>
                <tr class="d-flex">
                    <td class="col-6">Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ3A" id="answerQ3A">
                            <option {{$answer3A == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer3A == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ3A" id="yesAnswerQ3A" placeholder="if yes, give details" value="{{$answer3AYes}}"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <table class="table table-borderless sample-table" id="questionTable">
            <tbody>
                <tr class="d-flex">
                    <td class="col-6">Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ4A" id="answerQ4A">
                            <option {{$answer4A == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer4A == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ4A" id="yesAnswerQ4A" placeholder="if yes, give details" value="{{$answer4AYes}}"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <table class="table table-borderless sample-table" id="questionTable">
            <tbody>
                <tr class="d-flex">
                    <td class="col-6">a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ5A" id="answerQ5A">
                            <option {{$answer5A == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer5A == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ5A" id="yesAnswerQ5A" placeholder="if yes, give details" value="{{$answer5AYes}}"></td>
                </tr>
                <tr class="d-flex">
                    <td class="col-6">b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ5B" id="answerQ5B">
                            <option {{$answer5B == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer5B == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ5B" id="yesAnswerQ5B" placeholder="if yes, give details" value="{{$answer5BYes}}"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <table class="table table-borderless sample-table" id="questionTable">
            <tbody>
                <tr class="d-flex">
                    <td class="col-6">Have you acquired the status of an immigrant or permanent resident of another country?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ6A" id="answerQ6A">
                            <option {{$answer6A == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer6A == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ6A" id="yesAnswerQ6A" placeholder="if yes, give details" value="{{$answer6AYes}}"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <table class="table table-borderless sample-table" id="questionTable">
            <tbody>
                <tr class="d-flex">
                    <td class="col-6">Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</td>
                </tr>
                <tr class="d-flex">
                    <td class="col-6">Are you a member of any indigenous group?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ7A" id="answerQ7A">
                            <option {{$answer7A == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer7A == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ7A" id="yesAnswerQ7A" placeholder="if yes, give details" value="{{$answer7AYes}}"></td>
                </tr>
                <tr class="d-flex">
                    <td class="col-6">Are you a person with disability?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ7B" id="answerQ7B">
                            <option {{$answer7B == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer7B == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ7B" id="yesAnswerQ7B" placeholder="if yes, give details" value="{{$answer7BYes}}"></td>
                </tr>
                <tr class="d-flex">
                    <td class="col-6">Are you a solo parent?</td>
                    <td class="col-3">
                        <select class="form-control rounded-0" name="answerQ7C" id="answerQ7C">
                            <option {{$answer7C == 'no' ? 'selected' : ''}} value="no">No</option>
                            <option {{$answer7C == 'yes' ? 'selected' : ''}} value="yes">Yes</option>
                        </select>
                    </td>
                    <td class="col-3"><input type="text"class="form-control rounded-0" name="yesAnswerQ7C" id="yesAnswerQ7C" placeholder="if yes, give details" value="{{$answer7CYes}}"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
