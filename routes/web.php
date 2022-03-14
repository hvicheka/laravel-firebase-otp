<?php

use App\Http\Controllers\FirebaseController;
use Illuminate\Support\Facades\Route;
use Kreait\Firebase\Factory;


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


Route::get('/', [FirebaseController::class, 'index']);

Route::get('user', function () {
    // change $keyPath to yours, do not just copy and paste
    $keyPath = storage_path("app/firebase/firebase-key.json");
    $auth = (new Factory)->withServiceAccount($keyPath)->createAuth();

    try {
        // change $examplePhoneNumber to yours
        $examplePhoneNumber = '+85599282733';
        $user = $auth->getUserByPhoneNumber($examplePhoneNumber);
        dd($user);

    } catch (Exception $e) {
        echo $e->getMessage();
    }
});

Route::get('verify-id-token',function(){

    $idTokenString = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjJkYzBlNmRmOTgyN2EwMjA2MWU4MmY0NWI0ODQwMGQwZDViMjgyYzAiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vbGFyYXZlbC1maXJlYmFzZS03MzY5NSIsImF1ZCI6ImxhcmF2ZWwtZmlyZWJhc2UtNzM2OTUiLCJhdXRoX3RpbWUiOjE2NDcxNDc3MTcsInVzZXJfaWQiOiJ6MlRlN3BHWjBuWDVFRkp3SllrSExncE1zSG0yIiwic3ViIjoiejJUZTdwR1owblg1RUZKd0pZa0hMZ3BNc0htMiIsImlhdCI6MTY0NzE0NzcxNywiZXhwIjoxNjQ3MTUxMzE3LCJwaG9uZV9udW1iZXIiOiIrODU1OTkyODI3MzMiLCJmaXJlYmFzZSI6eyJpZGVudGl0aWVzIjp7InBob25lIjpbIis4NTU5OTI4MjczMyJdfSwic2lnbl9pbl9wcm92aWRlciI6InBob25lIn19.BFh17b-r_CHkkIrMoSX6IMOYmezQMdXjgrarMi4RsTQiiJfzMgos2EN2X3e0n_AezDc2O3wsp-hA5xdvMR0af8Oy7PBCI7Va_Zz6G1cwm_mipVq-WEif3hmne03OHaJDX2EiGLBCDN0t59tJVXcDyWo7z3OXSyHHoWHcCdLxN0Iy4d5U1zX9HrV3y0a0VxtowiXJ5hAGrjUla1jla4r-TPP0M_qG7E2ueYzhSgcY5XPQyG0k0m2yafxgYjKbUsqus5WzwyNRBMvXCOjL01FJMZK-azIjyyECxjG9HQFs9qjIEMRmuFOzxLr5VIJp-gFD-YVK-JZLIDbHT6FHPxs7hg";

    $keyPath = storage_path("app/firebase/firebase-key.json");
    $auth = (new Factory)->withServiceAccount($keyPath)->createAuth();

    try {
        $verifiedIdToken = $auth->verifyIdToken($idTokenString);
    } catch (FailedToVerifyToken $e) {
        echo 'The token is invalid: '.$e->getMessage();
    }

    $uid = $verifiedIdToken->claims()->get('sub');

    $user = $auth->getUser($uid);
    dd($user);
});

