<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthController отвечает за авторизацию пользователя
 *
 * @package App\Http\Controllers
 */

class AuthController extends Controller
{

    /** Авторизация и аутентификация пользователя
     *
     * Если введенные пользователем данные верны, то создается токен доступа,
     * который разрешает использование всех API в группе middleware(['jwt.auth'])->group
     * Попытка манипулирования данными из группы без аутентификации сопровождается ошибкой Unauthorized, 401
     *
     * @param Request $request
     * @return array|JsonResponse
     */

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'Неверный логин или пароль'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Не удалось создать токен доступа'], 500);
        }

        $response = compact('token');
        $response['user'] = Auth::user();

        return $response;
    }
}
