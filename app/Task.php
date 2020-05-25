<?php

namespace App;

use Illuminate\Http\JsonResponse;
use \Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use \DB;

/**
 * Class Task (дела в списках дел пользователя)
 *
 * @package App
 * @property integer $catalog_id id списка, в котором находится дело
 * @property string $name название дела, например, "Купить лимоны"
 * @property string|null $description полное описание дела
 * @property integer $status статус важности дела (от 1 до 5)
 */

class Task extends Model
{
    protected $fillable = [
        'name',
        'id',
        'catalog_id',
        'done',
        'description',
        'status'
    ];

    public function rules()
    {
        return [
            'name' => 'required|min:4',
            'status' => 'required|integer|between:1,5'
        ];

    }

    /**
     * Просмотр всех дел в конкретном списке дел
     *
     * @param $id integer id списка, в котором находятся запрашиваемые дела
     * @return array
     */

    public function showTasks($id)
    {
        return DB::table('tasks')
            ->select(['id', 'name', 'description', 'status', 'done', 'created_at', 'updated_at'])
            ->where('catalog_id', $id)
            ->get();
    }

    /**
     * Сортировка дел в списке
     *
     * @param $id integer id списка, в котором сортируются дела
     * @param $field string поле БД, по которому производится сортировка
     * @param $type string тип сортировки (ASC или DESC)
     * @return array
     */

    public function sortingBy($id, $field, $type)
    {
        return DB::table('tasks')
            ->select(['id', 'name', 'done', 'status', 'description', 'created_at', 'updated_at'])
            ->where('catalog_id', $id)
            ->orderBy($field, $type)
            ->get();
    }

    /**
     * Поиск по делам в списке
     *
     * @param $id integer id списка, в котором производится поиск по делам
     * @param $value string непосредственно сам запрос поиска, например, "Купить лимоны"
     * @return array
     */
    public function search($id, $value)
    {
        return DB::table('tasks')
            ->select(['id', 'name', 'done', 'status', 'description', 'created_at', 'updated_at'])
            ->where(['catalog_id' => $id])
            ->where('name', 'ILIKE', "%$value%") // нечувствительность к регистру
            ->get();
    }

    /**
     * Создание нового дела в списке
     *
     * @param Request $request
     * @param $id integer id списка, в котором производится создание дела
     * @return Task|JsonResponse
     */
    public function createNewTask(Request $request, $id)
    {
        $task = new Task();
        $task->catalog_id = $id;
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->status = $request->input('status');

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else $task->save();

        return $task;
    }

    /**
     * Редактирование дела
     *
     * @param Request $request
     * @param $id integer id дела, которое необходимо изменить
     * @return Task|JsonResponse
     */

    public function updateTask(Request $request, $id)
    {
        $update = Task::find($id);
        $update->name = $request->input('name');
        $update->description = $request->input('description');
        $update->status = $request->input('status');
        $update->done = $request->input('done');

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else $update->save();

        return $update;
    }

    /**
     * Изменения статуса выполненности дела
     *
     * @param $id integer id дела, отметку выполненности которого необходимо изменить
     * @param $mark boolean параметр принимает значения (false или true) для того,
     * чтобы отметить дело выполненным или наоборот снять отметку выполненности
     * @return array
     */
    public function changeStatus($id, $mark)
    {
        DB::table('tasks')
            ->where('id', $id)
            ->update(['done' => $mark]);
        return Task::find($id);
    }

    /**
     * Удаление дела из списка дел
     *
     * @param $id integer id дела, которое необходимо удалить
     * @return mixed
     */

    public function deleteTask($id)
    {
        return DB::table('tasks')
            ->where('id', $id)
            ->delete();

    }
}
