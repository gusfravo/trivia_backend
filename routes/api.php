<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth',
    'middleware' => 'cors'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('newsignup', 'AuthController@newsignup');
    Route::post('loginWithFacebook', 'AuthController@loginWithFacebook');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
    // * ================== Api con seguridad y CORS  =====================*/
    Route::group(['middleware' => 'cors'], function () {
    Route::group(['middleware' => 'auth:api'], function() {
      Route::post('role/list', 'RoleController@list');
      Route::post('role/findByName', 'RoleController@findByName');
      Route::post('profile/update', 'ProfileController@update');
      Route::post('profile/findByUser', 'ProfileController@findByUser');
      Route::post('trivia/update', 'TriviaController@update');
      Route::post('trivia/findAll', 'TriviaController@findAll');
      Route::post('question/update', 'QuestionController@update');
      Route::post('question/delete', 'QuestionController@delete');
      Route::post('answer/update', 'AnswerController@update');
      Route::post('answer/delete', 'AnswerController@delete');
      Route::post('answer/get', 'AnswerController@get');
      Route::post('answer/findAllByQuestion', 'AnswerController@findAllByQuestion');
      Route::post('game/create', 'GameController@create');
      Route::post('game/endGame', 'GameController@endGame');
      Route::post('game/updateTime', 'GameController@updateTime');
      Route::post('gameAnswer/validate', 'GameAnswerController@valid');
      Route::post('game/findByProfileAndTrivia', 'GameController@findByProfileAndTrivia');
      Route::post('game/get', 'GameController@get');
      Route::post('profile/get', 'ProfileController@get');
      Route::post('gameAnswer/findTotalsByGame', 'GameAnswerController@findTotalsByGame');
      Route::post('profile/upload', 'ProfileController@upload');
      Route::post('profile/updateImg', 'ProfileController@updateImg');
    });
    // * ================== Api sin seguridad y CORS cualquiera puede ejecutarlas. =====================*/
    Route::post('trivia/get', 'TriviaController@get');
    Route::post('question/get', 'QuestionController@get');
    Route::post('question/findAllByTrivia', 'QuestionController@findAllByTrivia');
    Route::post('answer/findAllByQuestionToPlay', 'AnswerController@findAllByQuestionToPlay');

  });
    // * ================== Api sin seguridad y sin CORS cualquiera puede ejecutarlas. =====================*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
