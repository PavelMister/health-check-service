<?php

declare(strict_types=1);

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Create user add assign default role
     * @throws \Throwable
     */
    public function register(array $data): ?User
    {
        return DB::transaction(function () use ($data) {
           $user = User::create($data);
           $user->password = bcrypt($data['password']);

           //$user->assignRole('customer');

           return $user;
        });
    }

    public function authenticate(array $data): ?User
    {
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return Auth::user();
        }

        return null;
    }
}
