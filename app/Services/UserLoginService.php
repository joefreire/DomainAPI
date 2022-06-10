<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;

class UserLoginService
{
    /**
     * Get a JWT via given credentials.
     *
     * @param  $data
     * @return array
     */
    public function userLogin($data)
    {
        if (!$token = Auth::attempt($data)) {
            return ['error' => 1, 'message' => 'Unauthorized'];
        }

        return $this->respondWithToken($token);
    }
    public function refresh()
    {
        $token = Auth::refresh();
        return $this->respondWithToken($token);
    }
    protected function respondWithToken($token)
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }
}
