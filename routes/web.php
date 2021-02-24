<?php

use App\Http\Controllers\AccomplishmentController;
use App\Http\Controllers\BureauController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubordinateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
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
Route::get('clear-cache', function () {
    Artisan::command('config:cache');
    Artisan::command('config:clear');
});

Route::group(['prefix' => ''], function () {
    Route::get('', [PageController::class, 'index'])->name('login');
});

Route::group(['middleware' => ['guest']], function () {
    Route::post('/login', [PageController::class, 'login']);

    Route::group(['prefix' => 'auto-time'], function () {
        Route::get('tito', [PageController::class, 'autoTito']);
    });

    Route::group(['prefix' => 'forgot-password'], function () {
        Route::get('',  [PageController::class, 'forgotPassword']);
        Route::post('submit',  [PageController::class, 'forgotPasswordSubmit']);

        Route::group(['prefix' => 'reset-password'], function () {
            Route::get('/{token}/{email}', [PageController::class, 'resetPassword']);
            Route::post('submit', [PageController::class, 'resetPasswordSubmit']);
        });
    });
});

Route::group(['middleware' => ['auth', 'linkPrevilage']], function () {

    Route::group(['prefix' => 'meeting'], function () {
        Route::group(['prefix' => 'add'], function () {
            Route::get('', [MeetingController::class, 'addMeetingForm']);
            Route::get('option', [MeetingController::class, 'optionForm']);
            Route::post('submit', [MeetingController::class, 'addMeetingSubmit']);

            Route::group(['prefix' => 'remarks'], function () {
                Route::get('', [MeetingController::class, 'addRemarksForm']);
                Route::post('submit', [MeetingController::class, 'addRemarksSubmit']);
            });
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

        Route::group(['prefix' => 'view'], function () {
            Route::get('{meetingId}', [MeetingController::class, 'viewMeeting']);
        });

        Route::group(['prefix' => 'actionable-item'], function () {
            Route::group(['prefix' => 'form'], function () {
                Route::get('', [MeetingController::class, 'actionableForm']);
                Route::post('submit', [MeetingController::class, 'actionableFormSubmit']);
            });

            Route::group(['prefix' => 'form-response'], function () {
                Route::get('', [MeetingController::class, 'actionableFormResponse']);
                Route::post('submit', [MeetingController::class, 'actionableFormResponseSubmit']);
            });

            Route::get('option', [MeetingController::class, 'actionableFormOption']);
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

        Route::group(['prefix' => 'bureau'], function () {
            Route::get('get-division', [UserController::class , 'getDivisions']);
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

    Route::group(['prefix' => 'bureau'], function () {
        Route::get('', [BureauController::class, 'index']);
        Route::post('list', [BureauController::class , 'indexList']);

        Route::group(['prefix' => 'add'], function () {
            Route::get('', [BureauController::class, 'addForm']);
            Route::post('submit', [BureauController::class, 'addSubmit']);
        });

        Route::group(['prefix' => 'update'], function () {
            Route::get('', [BureauController::class , 'updateForm']);
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

    Route::group(['prefix' => 'report'], function () {
        Route::group(['prefix' => 'accomplishment'], function () {
            Route::get('', [ReportController::class, 'indexAccomplishment']);
        });

        Route::group(['prefix' => 'dtr'], function () {
            Route::get('', [ReportController::class, 'indexTiTo']);
        });

        Route::group(['prefix' => 'meeting'], function () {
            Route::get('', [ReportController::class, 'indexMeeting']);

            Route::group(['prefix' => 'view'], function () {
                Route::get('{meetingId}', [ReportController::class, 'viewMeeting']);
            });

            Route::group(['prefix' => 'ended-meeting'], function () {
                Route::post('list', [ReportController::class , 'endedMeetingList']);
            });
        });

        Route::group(['prefix' => 'filter'], function () {
            Route::get('', [ReportController::class, 'filterForm']);
            Route::post('submit', [ReportController::class, 'filterSubmit']);
        });
    });

    Route::get('/show-document/{username}/{fileName}',[PageController::class, 'showDocuments']);

    Route::group(['prefix' => 'change-password'], function () {
        Route::group(['prefix' => 'form'], function () {
            Route::get('', [PageController::class , 'passwordForm']);
            Route::post('submit', [PageController::class , 'passwordSubmit']);
        });
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('', [PageController::class, 'notificationIndex']);
        Route::get('show', [PageController::class, 'showNotification']);
        Route::get('validate', [PageController::class, 'validateNotify']);
    });

    Route::group(['prefix' => 'my-qr-code'], function () {
        Route::get('', [PageController::class , 'myQrCode']);
        Route::get('download', [PageController::class , 'downloadMyQrCode']);
    });

    Route::group(['prefix' => 'my-signatory'], function () {
        Route::get('', [PageController::class , 'mySignatory']);
        Route::post('submit', [PageController::class , 'mySignatorySubmit']);
    });

    Route::group(['prefix' => 'chat'], function () {
        Route::get('', [ChatController::class, 'index']);
        Route::get('{username}', [ChatController::class, 'index']);

        Route::group(['prefix' => 'search'], function () {
            Route::get('search', [ChatController::class, 'searchUserGroup']);
        });

        Route::prefix('group')->group(function () {
            Route::prefix('create')->group(function () {
                Route::get('', [ChatController::class, 'createGroup']);
                Route::post('submit', [ChatController::class, 'submitGroup']);
                Route::post('update', [ChatController::class, 'updateGroup']);
            });

            Route::prefix('setting')->group(function () {
                Route::get('', [ChatController::class, 'settingGroup']);
            });
        });

        Route::prefix('seen')->group(function () {
            Route::get('view', [ChatController::class, 'viewSeen']);
        });

        Route::post('send', [ChatController::class , 'sendMessage']);
    });

    Route::group(['prefix' => 'subordinate'], function () {
        Route::get('', [SubordinateController::class , 'index']);
        Route::post('list', [SubordinateController::class , 'indexList']);
    });

    Route::get('logout', function () {
        Auth::logout();
        return redirect('');
    });
});
