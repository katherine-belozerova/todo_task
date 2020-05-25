<?php


namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Регистрация пользователя
     *
     * @param Request $request
     * @return User|JsonResponse
     */

    public function register(Request $request)
    {
        $model = new User();
        return $model->registerUser($request);
    }
}
