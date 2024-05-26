<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationEmailController extends Controller
{
    public function show()
    {
        return view('auth.verify');
    }

    public function verify(EmailVerificationRequest $request, $id, $hash)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'No such user exists.'], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return Redirect::to('/index')->with('verified', true);
        }

        if (!hash_equals($hash, sha1($user->email))) {
            return response()->json(['message' => 'Invalid or already used verification link.'], 400);
        }

        $user->markEmailAsVerified();

        return Redirect::to('/index')->with('verified', true);
    }

    public function resend(EmailVerificationRequest $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return back()->with('message', 'Email already verified.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
