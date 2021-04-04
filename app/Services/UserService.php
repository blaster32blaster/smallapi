<?php

namespace App\Services;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * handle user actions
 */
class UserService
{
    /**
     * fetch a single record
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user) : Response
    {
        return response($user);
    }

    /**
     * fetch all records
     *
     * @return Response
     */
    public function index() : Response
    {
        return response(User::all());
    }

    /**
     * store a new record
     *
     * @param UserCreateRequest $request
     * @return Response
     */
    public function store(UserCreateRequest $request) : Response
    {
        $user = new User;
        $user->fill($request->all());
        $user->password = Hash::make($request->get('password'));
        $user->save();

        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            logger()->error('token generation failed');
        }

        $user->token = $jwt_token;
        return response($user);
    }

    /**
     * update an existing record
     *
     * @param User $user
     * @param UserUpdateRequest $request
     * @return Response
     */
    public function update(User $user, UserUpdateRequest $request) : Response
    {
        $user->fill($request->all());
        if ($request->has('password')) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->save();

        $jwt_token = $this->handleUserPasswordOnUpdate($user, $request);

        $user->token = $jwt_token;
        return response($user);
    }

    /**
     * get a jwt token from request or header
     *
     * @param User $user
     * @param UserUpdateRequest $request
     * @return string
     */
    private function handleUserPasswordOnUpdate(User $user, UserUpdateRequest $request) : string
    {
        if (!$request->has('password')) {
            return $request->bearerToken();
        }

        $input = [
            'email' => $user->email,
            'password' => $request->get('password')
        ];

        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            logger()->error('token generation failed');
        }
        return $jwt_token;
    }
}
