<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        $status = Password::reset($request->validated(), function ($user, $password) {
            $user->forceFill(['password' => bcrypt($password)])->save();
        });

        return $status === Password::PASSWORD_RESET ? ['message' => trans('passwords.reset')] : response()->json(['errors' => ['password' => trans('passwords.token')]], 422);
    }
}
