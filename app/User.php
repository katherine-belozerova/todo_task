<?php


namespace App;

use Illuminate\Http\JsonResponse;
use \Validator;
use Illuminate\Http\Request;
use \Str;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User - подель пользователей, реализующая интерфейс JWTSubject (авторизация по JsonWebToken)
 *
 * @package App
 * @property string $username логин пользователя
 * @property string $name имя пользователя
 * @property string $password пароль пользователя
 */

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'id',
        'name',
        'username',
        'password'
    ];

    public function rules()
    {
        return [
            'name'=>'required|max:32|min:2|alpha',
            'username'=>'required|max:32|min:6|unique:users',
            'password'=>'required|max:32|min:6|confirmed',
        ];

    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Абстрактный метод интерфейса
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Регистрация пользователя
     *
     * @param Request $request
     * @return User|JsonResponse
     */

    public function registerUser(Request $request)
    {
        $user = new User();

        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else $user->save();

        return $user;
    }

}
