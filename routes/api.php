<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\MissionController;
use App\Http\Controllers\API\FormController;
use App\Http\Controllers\API\ValidateController;
use App\Http\Controllers\API\CommentController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

Route::middleware('auth:sanctum')->resource("users", UserController::class)->only(['index', 'show']); // Les routes "users.*" de l'API
Route::middleware('auth:sanctum')->resource("missions", MissionController::class)->only(['index', 'show']); // Les routes "missions.*" de l'API
Route::middleware('auth:sanctum')->resource("forms", FormController::class)->only(['index', 'show']); // Les routes "forms.*" de l'API
Route::middleware('auth:sanctum')->resource("validates", ValidateController::class)->only(['index', 'show', 'store', 'update']); // Les routes "validates.*" de l'API
Route::middleware('auth:sanctum')->resource("comments", CommentController::class)->only(['store', 'update', 'destroy']); // Les routes "comments.*" de l'API
Route::post('/authorization-request', function (Request $request) {

    if (!$request->ajax()) {
        return abort(404);
    }

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $user->tokens()->where(['tokenable_id' => $user->id, 'name' => $request->device_name])->delete();
    return ['token' => $user->createToken($request->device_name)->plainTextToken, 'id' => $user->id];
});
Route::post('/disconnect-from-all', function (Request $request) {

    if (!$request->ajax()) {
        return abort(404);
    }

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $user->tokens()->where([['tokenable_id', '=', $user->id], ['name', '!=', $request->device_name]])->delete();
    return ['message' => __('All your other devices have been disconnected.'), 'id' => $user->id];
});
