<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'exists:users,email']]);

        $status = Password::sendResetLink($data);

        return $status === Password::RESET_LINK_SENT ? ['message' => trans('passwords.sent')] : response()->json(['errors' => ['email' => $status]]);
    }
}
