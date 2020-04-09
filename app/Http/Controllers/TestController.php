<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function test($id)
    {
        if (DB::table('catalogs')->where('id', $id)->exists()) {
            return 'Такой каталог существует';
        } else return 'Такой каталог не существует';
    }
}
