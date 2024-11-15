<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenController extends Controller
{
    public function invalidateToken(Request $request)
{
    $token = $request->input('token');
    if (!$token) {
        return response()->json(['error' => 'Token is required'], 400);
    }

    try {

        $payload = JWTAuth::setToken($token)->getPayload();
        JWTAuth::invalidate($token);

        return response()->json(['message' => 'Token invalidated', 'status' => "success"]);
    } catch (TokenInvalidException $e) {
        return response()->json(['error' => 'Token is invalid'], 400);
    } catch (TokenExpiredException $e) {
        return response()->json(['error' => 'Token has expired'], 400);
    } catch (JWTException $e) {
        return response()->json(['error' => 'Could not parse token'], 400);
    } catch (\Exception $e) {
        // Log any other exceptions for further investigation
        \Log::error('Token invalidation error: ', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'An unexpected error occurred'], 500);
    }
}

}
