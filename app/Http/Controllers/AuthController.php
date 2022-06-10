<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Service\UserLoginService;
use App\Actions\CreateUser;

class AuthController extends Controller
{
    public function register(UserStoreRequest $request, CreateUser $action)
    {
        $data = $request->parse();
        $user = $action->handle($data);
        return $this->buildResponse('success', $user);
    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->parse();
        $service = new UserLoginService();
        $user = $service->userLogin($data);
        return $this->buildLoginResponse($user);
    }
    public function me()
    {
        return $this->buildLoginResponse(auth()->user());
    }
    public function refresh()
    {
        $service = new UserLoginService();
        return $this->buildLoginResponse($service->refresh());
    }
}
