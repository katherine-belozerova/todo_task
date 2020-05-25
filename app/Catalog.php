<?php

namespace App;

use Illuminate\Http\JsonResponse;
use \Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use \DB;

/**
 * Class Catalog (список дел пользователя)
 *
 * @package App
 * @property integer user_id
 * @property string name
 */

class Catalog extends Model
{
    protected $fillable = [
        'name',
        'id',
        'user_id',
        'done'
    ];

    public function rules()
    {
        return [
            'name'=>'required|min:4'
        ];

    }

    /**
     * Просмотр всех списков дел конкретного пользователя
     *
     * @param $id integer id паользователя, чьи списки дел хотим просмотреть
     * @return array
     */

    public function showMyCatalogs($id)
    {
        return DB::table('catalogs')
            ->select(['id', 'name', 'done', 'created_at', 'updated_at'])
            ->where('user_id', $id)
            ->get();
    }

    /**
     * Просмотр всех выполненных или невыполненных списков дел пользователя
     *
     * Выбор между выполненными и невыполненными осуществляется с помощью входного параметра $done
     *
     * @param $id integer id пользователя, чьи списки дел хотим просмотреть
     * @param $done boolean false = список не выполнен, true - список выполнен
     * @return array
     */

    public function findByDone($id, $done)
    {
        return DB::table('catalogs')
            ->select(['id', 'name', 'done', 'created_at', 'updated_at'])
            ->where('user_id', $id)
            ->where('done', $done)
            ->get();
    }

    /**
     * Сортировка по параметру $field выполненных или невыполненных списков дел
     *
     * @param $id integer id пользователя, чьи списки дел хотим отсортировать
     * @param $field string поле БД, по которому будет осуществляться сортировка
     * @param $type string тип сортировки (ASC - в прямом порядке (по умолчанию), DESC - в обратном порядке)
     * @param $done boolean false = список дел не выполнен, true - список выполнен
     * @return array
     */

    public function sortingBy($id, $field, $type, $done)
    {
        return DB::table('catalogs')
            ->select(['id', 'name', 'done', 'created_at', 'updated_at'])
            ->where('user_id', $id)
            ->where('done', $done)
            ->orderBy($field, $type)
            ->get();
    }

    /**
     * Поиск
     *
     * Нечувствительный к регистру поиск по всем спискам дел конкретного пользователя
     *
     * @param $id integer id пользователя, в чьих списках дел производится поиск
     * @param $value string непосредственно сам запрос поиска, например "Сходить в магазин"
     * @return array
     */

    public function search($id, $value)
    {
        return DB::table('catalogs')
            ->select(['id', 'name', 'done', 'created_at', 'updated_at'])
            ->where(['user_id' => $id])
            ->where('name', 'ILIKE', "%$value%")
            ->get();
    }

    /**
     * Создание нового списка дел
     *
     * @param Request $request
     * @param $id integer id пользователя, который создает список дел
     * @return Catalog|JsonResponse
     */

    public function createNewCatalog(Request $request, $id)
    {
        $catalog = new Catalog();
        $catalog->user_id = $id;
        $catalog->name = $request->input('name');

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else $catalog->save();

        return $catalog;
    }

    /**
     * Редактирование списка дел
     *
     * @param Request $request
     * @param $id integer id списка дел, который необходимо отредактировать
     * @return Catalog|JsonResponse
     */

    public function updateCatalog(Request $request, $id)
    {
        $update = Catalog::find($id);
        $update->name = $request->input('name');

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else $update->save();

        return $update;
    }

    /**
     * Отметить список дел как выполненный или снять отметку выполненности
     *
     * Если список отметить выполненным, то все дела внутри него, отметятся, как выполненные
     *
     * @param $id integer id списка дел, которому необходимо изменить отметку выполненности
     * @param $mark boolean true - список дел выполнен, false - невыполнен
     * @return Catalog|JsonResponse
     */

    public function changeStatus($id, $mark)
    {
        if ($mark = true){
            DB::table('catalogs')
                ->where('id', $id)
                ->update(['done' => true]);
            DB::table('tasks')
                ->where('catalog_id', $id)
                ->update(['done' => true]);
            return Catalog::find($id);
        } else
        DB::table('catalogs')
            ->where('id', $id)
            ->update(['done' => false]);
        return Catalog::find($id);
    }

    /**
     * Удаление списка дел
     *
     * Если удалить список дел, то удалятся и все пложенные в него дела
     *
     * @param $id integer id списка, который необходимо удалить
     * @return string
     */

    public function deleteCatalog($id)
    {
        DB::table('catalogs')
            ->where('id', $id)
            ->delete();

        DB::table('tasks')
            ->where('catalog_id', $id)
            ->delete();

        return 'Список и все вложенные дела успешно удалены';
    }

}
