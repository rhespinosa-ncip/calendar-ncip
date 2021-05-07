<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Questions extends Model
{
    use HasFactory;

    protected $table = 'questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'question',
        'answer',
        'if_yes',
    ];


    static function insertUpdate($request){
        $questions = array(
            'Q1A', 'Q1B', 'Q2A', 'Q2B', 'Q3A', 'Q4A', 'Q5A', 'Q5B', 'Q6A', 'Q7A', 'Q7B', 'Q7C'
        );

        foreach($questions as $question){
            $answer = 'answer'.$question;
            $yesAnswer = 'yesAnswer'.$question;

            $question = Questions::firstOrNew(array('user_id' => Auth::id(), 'question' => 'question'.$question));
            $question->answer = $request->$answer;
            $question->if_yes = $request->$answer == 'yes' ? $request->$yesAnswer : '';
            $question->save();
        }

    }
}
