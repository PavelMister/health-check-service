<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Requests\Users\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\RegisterRequest;

class UsersController extends Controller
{

    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * Controller method for register new user
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->register($request->validated());

        return $this->success($user, __('auth.registered'));
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userService->authenticate($request->validated());

        return $this->success($user, __('auth.authenticated'));
    }
}
