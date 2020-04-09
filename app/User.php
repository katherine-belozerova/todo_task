<?php


namespace App;

use Validator;
use Illuminate\Http\Request;
use \Str;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'id',
        'name',
        'username',
        'password',
        'token'
    ];

    public function rules()
    {
        return [
            'name'=>'required|max:32|alpha',
            'username'=>'required|max:32|unique:users|min:6',
            'password'=>'required|max:32|min:6|confirmed',
        ];

    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function registerUser(Request $request)
    {
        $user = new User();

        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->token = Str::random(32);

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else $user->save();

        return $user;
    }

}
