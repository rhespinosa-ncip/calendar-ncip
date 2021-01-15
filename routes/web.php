<?php

use App\Http\Controllers\AccomplishmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::fallback(function () {
    return redirect('/');
});

Route::group(['prefix' => ''], function () {
    Route::get('', [PageController::class, 'index'])->name('login');
});

Route::group(['middleware' => ['guest']], function () {
    Route::post('/login', [PageController::class, 'login']);

    Route::group(['prefix' => 'auto-time'], function () {
        Route::get('tito', [PageController::class, 'autoTito']);
    });
});

Route::group(['middleware' => ['auth', 'linkPrevilage']], function () {

    Route::group(['prefix' => 'meeting'], function () {
        Route::group(['prefix' => 'add'], function () {
            Route::get('', [MeetingController::class, 'addMeetingForm']);
            Route::get('option', [MeetingController::class, 'optionForm']);
            Route::post('submit', [MeetingController::class, 'addMeetingSubmit']);
        });

        Route::get('show', [MeetingController::class, 'showMeeting']);

        Route::group(['prefix' => 'admin'], function () {
            Route::get('', [MeetingController::class, 'adminMeetings']);
            Route::post('list', [MeetingController::class , 'adminMeetingsList']);

            Route::group(['prefix' => 'meeting-link'], function () {
                Route::get('', [MeetingController::class, 'meetingLinkForm']);
                Route::post('submit', [MeetingController::class, 'meetingLinkSubmit']);
            });
        });

        Route::group(['prefix' => 'ended-meeting'], function () {
            Route::post('list', [MeetingController::class , 'endedMeetingList']);

            Route::group(['prefix' => 'maintenance'], function () {
                Route::get('', [MeetingController::class , 'minutesForm']);
                Route::post('submit', [MeetingController::class, 'minutesFormSubmit']);
            });
        });
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('', [UserController::class , 'index']);
        Route::post('list', [UserController::class , 'indexList']);

        Route::group(['prefix' => 'add'], function () {
            Route::get('', [UserController::class , 'addUserForm']);
            Route::post('submit', [UserController::class, 'addUserSubmit']);
        });

        Route::group(['prefix' => 'update'], function () {
            Route::get('', [UserController::class , 'updateUserForm']);
        });
    });

    Route::group(['prefix' => 'tito'], function () {
        Route::post('time-in', [UserController::class, 'timeUser']);
    });

    Route::group(['prefix' => 'department'], function () {
        Route::get('', [DepartmentController::class , 'index']);
        Route::post('list', [DepartmentController::class , 'indexList']);

        Route::group(['prefix' => 'add'], function () {
            Route::get('', [DepartmentController::class , 'addDepartmentForm']);
            Route::post('submit', [DepartmentController::class, 'addDepartmentSubmit']);
        });

        Route::group(['prefix' => 'update'], function () {
            Route::get('', [DepartmentController::class , 'updateUserForm']);
        });
    });

    Route::group(['prefix' => 'accomplishment'], function () {
        Route::get('', [AccomplishmentController::class , 'index']);
        Route::post('list', [AccomplishmentController::class, 'indexList']);

        Route::group(['prefix' => 'record'], function () {
            Route::get('', [AccomplishmentController::class, 'formAccomplishment']);
            Route::post('submit', [AccomplishmentController::class, 'submitAccomplishment']);
        });
    });

    Route::get('/show-document/{username}/{fileName}',[PageController::class, 'showDocuments']);

    Route::group(['prefix' => 'change-password'], function () {
        Route::group(['prefix' => 'form'], function () {
            Route::get('', [PageController::class , 'passwordForm']);
            Route::post('submit', [PageController::class , 'passwordSubmit']);
        });
    });

    Route::group(['prefix' => 'my-qr-code'], function () {
        Route::get('', [PageController::class , 'myQrCode']);
        Route::get('download', [PageController::class , 'downloadMyQrCode']);

    });

    Route::get('logout', function () {
        Auth::logout();
        return redirect('');
    });
});
