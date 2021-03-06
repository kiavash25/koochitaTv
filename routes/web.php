<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
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

Route::get('/kish', function(){
   return redirect('http://5.253.24.93');
});
Route::post('updateLink', ["as" => "updateLink", "uses" => "StreamingController@updateLink"]);

Route::get("liveTest", function () {
    return view('stream');
});

Route::get("getLive/{code}", function ($code) {
    return view('getLive', ['url' => $code]);
});

Route::get("pyGetLive/{code}", function ($code) {
    return view('getLive2', ['url' => $code]);
});

Route::post('log/storeSeenLog', 'MainController@storeSeenLog')->name('log.storeSeen');

Route::middleware(['web', 'vodShareData'])->group(function (){

    Route::get('/', [MainController::class ,'indexStreaming'])->name('index');

    Route::get('profile/page/{user:username}', [ProfileController::class ,'showProfile'])->name('profile.show');

    Route::post('video/search', [MainController::class ,'search'])->name('video.search');

    Route::get('list/{kind}/{value}', [MainController::class ,'videoList'])->name('video.list');

    Route::post('getListElems', [MainController::class ,'getVideoListElems'])->name('video.list.getElems');

    Route::get('video/show/{code}', [MainController::class ,'showVideo'])->name('video.show');

    Route::middleware(['auth'])->group(function () {

        Route::post('video/updateTopVideo', 'ProfileController@updateTopVideo')->name('profile.updateTopVideo');

        Route::prefix('video/playList')->group(function(){
            Route::post('store', 'PlayListController@newPlayList')->name('playList.new');

            Route::post('delete', 'PlayListController@deletePlayList')->name('playList.delete');

            Route::post('edit/name', 'PlayListController@editPlayListName')->name('playList.edit.name');

            Route::post('edit/videoList', 'PlayListController@updatePlayListVideos')->name('playList.edit.videoList');

            Route::post('edit/updateVideoSort', 'PlayListController@editPlayListVideoSort')->name('playList.edit.updateVideoSort');

            Route::post('edit/deleteVideo', 'PlayListController@deleteVideoFromPlayList')->name('playList.edit.deleteVideo');
        });

        Route::post('profile/updateBannerPic', 'ProfileController@updateBannerPic')->name('profile.updateBanner');

        Route::post('video/addToBookMark', 'ProfileController@addToBookMark')->name('profile.addToBookMark');

        Route::post('video/setVideoFeedback', 'MainController@setVideoFeedback')->name('video.setVideoFeedback');

        Route::post('video/setVideoComment', 'MainController@setVideoComment')->name('video.setVideoComment');
    });

//    upload video
    Route::middleware(['auth'])->group(function(){
        Route::post('video/yourCategory/store', 'VideoController@newYourCategory')->name('video.yourCategory.new');

        Route::get('video/uploadPage', 'VideoController@uploadVideoPage')->name('video.uploadPage');

        Route::post('video/storeVideo', 'VideoController@uploadVideoFile')->name('video.uploadVideoFile');

        Route::delete('video/uploadedFile/delete', 'VideoController@deleteUploadedFile')->name('video.uploadFile.delete');

        Route::post('video/storeVideoInfo', 'VideoController@storeVideoInfo')->name('video.storeVideoInfo');
    });

//authenticated controller
    Route::group(array('middleware' => ['throttle:30']), function(){
//    Route::get('login', 'UserLoginController@login');
        Route::get('newPasswordEmail/{code}', 'UserLoginController@newPasswordEmailPage')->name('newPasswordEmail');

        Route::post('setNewPasswordEmail', 'UserLoginController@setNewPasswordEmail')->name('setNewPasswordEmail');

        Route::post('checkLogin', array('as' => 'checkLogin', 'uses' => 'UserLoginController@checkLogin'));

        Route::get('login', array('as' => 'login', 'uses' => 'UserLoginController@mainDoLogin'));

        Route::post('login2', array('as' => 'login2', 'uses' => 'UserLoginController@doLogin'));

        Route::post('checkEmail', array('as' => 'checkEmail', 'uses' => 'UserLoginController@checkEmail'));

        Route::post('checkUserName', array('as' => 'checkUserName', 'uses' => 'UserLoginController@checkUserName'));

        Route::post('registerAndLogin', array('as' => 'registerAndLogin', 'uses' => 'UserLoginController@registerAndLogin'));

        Route::post('registerWithPhone', array('as' => 'registerWithPhone', 'uses' => 'UserLoginController@registerWithPhone'));

        Route::post('registerAndLogin2', array('as' => 'registerAndLogin2', 'uses' => 'UserLoginController@registerAndLogin2'));

        Route::post('retrievePasByEmail', array('as' => 'retrievePasByEmail', 'uses' => 'UserLoginController@retrievePasByEmail'));

        Route::post('retrievePasByPhone', array('as' => 'retrievePasByPhone', 'uses' => 'UserLoginController@retrievePasByPhone'));

        Route::post('setNewPassword', 'UserLoginController@setNewPassword')->name('user.setNewPassword');

        Route::post('checkPhoneNum', array('as' => 'checkPhoneNum', 'uses' => 'UserLoginController@checkPhoneNum'));

        Route::post('checkRegisterData', 'UserLoginController@checkRegisterData')->name('checkRegisterData');

        Route::post('checkActivationCode', array('as' => 'checkActivationCode', 'uses' => 'UserLoginController@checkActivationCode'));

        Route::post('resendActivationCode', array('as' => 'resendActivationCode', 'uses' => 'UserLoginController@resendActivationCode'));

        Route::post('resendActivationCodeForget', array('as' => 'resendActivationCodeForget', 'uses' => 'UserLoginController@resendActivationCodeForget'));

        Route::post('checkReCaptcha', array('as' => 'checkReCaptcha', 'uses' => 'UserLoginController@checkReCaptcha'));

        Route::get('loginWithGoogle', array('as' => 'loginWithGoogle', 'uses' => 'UserLoginController@loginWithGoogle'));

        Route::get('logout', array('as' => 'logout', 'uses' => 'UserLoginController@logout'));
    });

    Route::get('/importVideoToDB', 'StreamingController@importVideoToDB');

    Route::get('/setVideoDuration', 'StreamingController@setVideoDuration');

    Route::get('policies', function(){ dd('policies'); })->name('policies');
    Route::get('profile', function(){ dd('profile'); })->name('profile');
});

Route::middleware(['web'])->group(function(){

    Route::middleware(['vodShareData'])->group(function(){
        Route::get('streaming/live/{room?}', 'LiveController@streamingLive')->name('streaming.live');

        Route::get('live/{room?}', 'LiveController@streamingLive');

        Route::get('testLive/{room}/{playTime}', 'LiveController@testLive');
    });

    Route::middleware(['auth'])->group(function(){
        Route::post('streaming/storeLiveChat', 'LiveController@storeLiveChat')->name('streaming.storeLiveChat');
        Route::post('streaming/live/sendBroadcastMsg', 'LiveController@sendBroadcastMsg')->name('sendBroadcastMsg');
        Route::post('streaming/live/setVideoFeedback', 'LiveController@setLiveFeedback')->name('streaming.live.setLiveFeedback');
    });

    Route::get('getLiveLink', 'LiveController@getLiveUrl')->name('streaming.getLiveUrl');
    Route::get('streaming/getChats/{room}', 'LiveController@updateLiveVideoChat')->name('streaming.getChats');

    Route::post('getLiveUserSeen', 'LiveController@getLiveUserSeen')->name('streaming.getLiveUserSeen');
});

Route::middleware(['web'])->group(function(){
    Route::get('ajax/getVideoPlaces', [AjaxController::class, 'getVideoPlaces'])->name('ajax.getVideoPlaces');

    Route::get('ajax/totalPlaceSearch', [AjaxController::class, 'totalPlaceSearch'])->name('ajax.totalPlaceSearch');

    Route::get('ajax/getTags', [AjaxController::class, 'getTags'])->name('ajax.getTags');
});

Auth::routes();


