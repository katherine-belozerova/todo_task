<?php

namespace App;

use Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use \DB;

class Catalog extends Model
{
    protected $fillable = [
        'name',
        'id',
        'user_id',
        'created_at',
        'updated_at',
        'done'
    ];

    public function rules()
    {
        return [
            'name'=>'required|min:16',
        ];

    }

    public function showMyCatalogs($id)
    {
        return DB::table('catalogs')
            ->select(['id', 'name', 'done', 'created_at', 'updated_at'])
            ->where('user_id', $id)
            ->get();
    }

    public function findByDone($id, $done)
    {
        return DB::table('catalogs')
            ->select(['id', 'name', 'done', 'created_at', 'updated_at'])
            ->where('user_id', $id)
            ->where('done', $done)
            ->get();
    }

    public function sortingBy($id, $field, $type, $done)
    {
        return DB::table('catalogs')
            ->select(['id', 'name', 'done', 'created_at', 'updated_at'])
            ->where('user_id', $id)
            ->where('done', $done)
            ->orderBy($field, $type)
            ->get();
    }

    public function search($id, $value)
    {
        return DB::table('catalogs')
            ->select(['id', 'name', 'done', 'created_at', 'updated_at'])
            ->where(['user_id' => $id])
            ->where('name', 'ILIKE', "%$value%")
            ->get();
    }

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

    public function changeStatus($id, $mark)
    {
        return DB::table('catalogs')
            ->where('id', $id)
            ->update(['done' => $mark]);
    }

    public function deleteCatalog($id)
    {
        // Удаление задачи по ее id
        DB::table('catalogs')
            ->where('id', $id)
            ->delete();

        // Удаление всех подзадач в данной задаче
        DB::table('tasks')
            ->where('catalog_id', $id)
            ->delete();

        return 'Задача и все вложенные подзадачи успешно удалены';
    }



}
