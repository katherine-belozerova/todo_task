<?php


namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $model = new User();
        return $model->registerUser($request);
    }
}
