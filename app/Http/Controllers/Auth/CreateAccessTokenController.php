<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CreateAccessTokenController extends Controller
{
    public function create(Request $request): ?JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /**
             * @var User $user
             */
            $user = Auth::user();

            if (!$user)
                return response()->json(['message' => 'Connot find user'], 404);

            $token = $user->createToken('MyAppToken')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Auth failed'], 403);
        }
    }
}
