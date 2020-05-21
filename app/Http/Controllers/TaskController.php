<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Отображение всех тасков конкретного списка
    public function tasks($id)
    {
        $model = new Task();
        return $model->showTasks($id);
    }

    // Сортировка
    public function sorting($id, $field)
    {
        $model = new Task();
        return $model->sortingBy($id, $field, $type = 'asc');
    }

    // Поиск по всем таскам
    public function searching($id, $value)
    {
        $model = new Task();
        return $model->search($id, $value);
    }

    // Создание нового списка
    public function create(Request $request, $id)
    {
        $model = new Task();
        return $model->createNewTask($request, $id);
    }

    // Редактирование списка
    public function update(Request $request, $id)
    {
        $model = new Task();
        return $model->updateTask($request, $id);
    }

    // Отметка выполненности
    public function done($id)
    {
        $model = new Task();
        return $model->changeStatus($id, $mark = true);
    }

    public function notDone($id)
    {
        $model = new Task();
        return $model->changeStatus($id, $mark = false);
    }

    public function delete($id)
    {
        $model = new Task();
        return $model->deleteTask($id);
    }
}
