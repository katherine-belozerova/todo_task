<?php

namespace App\Http\Controllers;

use App\Lists;
use Illuminate\Http\Request;

class ListsController extends Controller
{

    const DONE = 't'; // boolean true
    const NOT_DONE = 'f'; // boolean false

    // Отображение всех списков дел и их отметок выполненности конкретного пользователя
    public function lists($user_id)
    {
        $model = new Lists();
        return $model->showMyLists($user_id);
    }
    // Создание нового списка
    public function create(Request $request, $user_id)
    {
        $model = new Lists();
        return $model->createNewList($request, $user_id);
    }

    // Редактирование списка
    public function update(Request $request, $list_id)
    {
        $list = new Lists();
        return $list->updateList($request, $list_id);
    }

    // Отметка выполненности
    public function done($list_id)
    {
        $list = new Lists();
        return $list->changeStatus($list_id, $mark = self::DONE);
    }

    public function notDone($list_id)
    {
        $list = new Lists();
        return $list->changeStatus($list_id, $mark = self::NOT_DONE);
    }

    public function delete($list_id)
    {
        $list = new Lists();
        return $list->deleteList($list_id);
    }

}
