<?php

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

Route::middleware(['web', 'vodShareData'])->group(function (){
    Route::get('/', 'MainController@indexStreaming')->name('index');

    Route::post('video/search', 'MainController@search')->name('video.search');

    Route::get('list/{kind}/{value}', 'MainController@videoList')->name('video.list');

    Route::post('getListElems', 'MainController@getVideoListElems')->name('video.list.getElems');


    Route::get('video/show/{code}', 'MainController@showVideo')->name('video.show');

    Route::get('streaming/live/{room?}', 'MainController@streamingLive')->name('streaming.live');


    Route::middleware(['auth'])->group(function () {
        Route::get('video/uploadPage', 'MainController@uploadVideoPage')->name('video.uploadPage');

        Route::post('video/storeVideo', 'MainController@storeVideo')->name('video.storeVideo');

        Route::post('video/storeVideoInfo', 'MainController@storeVideoInfo')->name('video.storeVideoInfo');

        Route::post('video/setVideoFeedback', 'MainController@setVideoFeedback')->name('video.setVideoFeedback');

        Route::post('video/setVideoComment', 'MainController@setVideoComment')->name('video.setVideoComment');

        Route::post('streaming/live/sendBroadcastMsg', 'MainController@sendBroadcastMsg')->name('sendBroadcastMsg');

        Route::post('streaming/live/setVideoFeedback', 'MainController@setLiveFeedback')->name('streaming.live.setLiveFeedback');
    });


//authenticated controller
    Route::middleware(['throttle:30'])->group(function(){

        Route::get('login', 'UserLoginController@login');

        Route::post('login', array('as' => 'login', 'uses' => 'UserLoginController@mainDoLogin'));

        Route::post('checkLogin', array('as' => 'checkLogin', 'uses' => 'UserLoginController@checkLogin'));

        Route::post('login2', array('as' => 'login2', 'uses' => 'UserLoginController@doLogin'));

        Route::post('checkEmail', array('as' => 'checkEmail', 'uses' => 'UserLoginController@checkEmail'));

        Route::post('checkUserName', array('as' => 'checkUserName', 'uses' => 'UserLoginController@checkUserName'));

        Route::post('registerAndLogin', array('as' => 'registerAndLogin', 'uses' => 'UserLoginController@registerAndLogin'));

        Route::post('registerWithPhone', array('as' => 'registerWithPhone', 'uses' => 'UserLoginController@registerWithPhone'));

        Route::post('retrievePasByEmail', array('as' => 'retrievePasByEmail', 'uses' => 'UserLoginController@retrievePasByEmail'));

        Route::post('retrievePasByPhone', array('as' => 'retrievePasByPhone', 'uses' => 'UserLoginController@retrievePasByPhone'));

        Route::post('checkPhoneNum', array('as' => 'checkPhoneNum', 'uses' => 'UserLoginController@checkPhoneNum'));

        Route::post('checkActivationCode', array('as' => 'checkActivationCode', 'uses' => 'UserLoginController@checkActivationCode'));

        Route::post('resendActivationCode', array('as' => 'resendActivationCode', 'uses' => 'UserLoginController@resendActivationCode'));

        Route::post('resendActivationCodeForget', array('as' => 'resendActivationCodeForget', 'uses' => 'UserLoginController@resendActivationCodeForget'));

        Route::post('checkReCaptcha', array('as' => 'checkReCaptcha', 'uses' => 'UserLoginController@checkReCaptcha'));

        Route::get('loginWithGoogle', array('as' => 'loginWithGoogle', 'uses' => 'UserLoginController@loginWithGoogle'));

        Route::get('logout', array('as' => 'logout', 'uses' => 'UserLoginController@logout'));
    });





    Route::get('profile', function(){
        dd('profile');
    })->name('profile');

    Route::get('/importVideoToDB', 'StreamingController@importVideoToDB');

    Route::get('/setVideoDuration', 'StreamingController@setVideoDuration');

    Route::get('policies', function(){
        dd('policies');
    })->name('policies');
});

Route::post('getTags', 'AjaxController@getTags')->name('getTags');

Auth::routes();


