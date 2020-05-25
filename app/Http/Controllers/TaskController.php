<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Отображение всех дел конкретного списка
     *
     * @param $id integer id списка, в котором хотим просмотреть все вложенные дела
     * @return array
     */

    public function tasks($id)
    {
        $model = new Task();
        return $model->showTasks($id);
    }

    /**
     * Сортировка
     *
     * @param $id integer id списка, в котором хотим отсортировать дела
     * @param $field string поле БД, по которому производится ASC сортировка
     * @return array
     */

    public function sorting($id, $field)
    {
        $model = new Task();
        return $model->sortingBy($id, $field, $type = 'asc');
    }

    /**
     * Поиск (не чувствительный к регистру) по всем делам в конкретном списке
     *
     * @param $id integer id списка, в котором производится поиск
     * @param $value string непосредственно сам запрос поиска, напримемр, "Купить лимоны"
     * @return array
     */

    public function searching($id, $value)
    {
        $model = new Task();
        return $model->search($id, $value);
    }

    /**
     * Создание нового дела в списке дел
     *
     * @param Request $request
     * @param $id integer id списка, в котором создается дело
     * @return Task|JsonResponse
     */

    public function create(Request $request, $id)
    {
        $model = new Task();
        return $model->createNewTask($request, $id);
    }

    /**
     * Редактирование дела в списке дел
     *
     * @param Request $request
     * @param $id integer id редактируемого дела
     * @return JsonResponse
     */

    public function update(Request $request, $id)
    {
        $model = new Task();
        return $model->updateTask($request, $id);
    }

    /**
     * Отметка выполненности дела
     *
     * @param $id integer id дела, которое необходимо отметить как выполненное
     * @var $mark boolean значение true  в качестве пердваемого параметра указыват,
     * что дело необходимо отметить как выполненное
     * @return array
     */

    public function done($id)
    {
        $model = new Task();
        return $model->changeStatus($id, $mark = true);
    }

    /**
     * Отметить дело, как невыполненное
     *
     * @param $id integer id дела, которое необходимо отметить как невыполненное
     * @var $mark boolean значение false  в качестве пердваемого параметра указыват,
     * что дело необходимо отметить как невыполненное
     * @return array
     */

    public function notDone($id)
    {
        $model = new Task();
        return $model->changeStatus($id, $mark = false);
    }

    /**
     * Удаление дела
     *
     * @param $id integer id дела, которое необходимо удалить
     * @return mixed
     */
    public function delete($id)
    {
        $model = new Task();
        return $model->deleteTask($id);
    }
}
