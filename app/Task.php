<?php

namespace App;

use Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use \DB;

class Task extends Model
{
    protected $fillable = [
        'name',
        'id',
        'catalog_id',
        'created_at',
        'updated_at',
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

    public function showTasks($id)
    {
        return DB::table('tasks')
            ->select(['id', 'name', 'description', 'status', 'done', 'created_at', 'updated_at'])
            ->where('catalog_id', $id)
            ->get();
    }

    public function sortingBy($id, $field, $type)
    {
        return DB::table('tasks')
            ->select(['id', 'name', 'done', 'status', 'description', 'created_at', 'updated_at'])
            ->where('catalog_id', $id)
            ->orderBy($field, $type)
            ->get();
    }

    public function search($id, $value)
    {
        return DB::table('tasks')
            ->select(['id', 'name', 'done', 'status', 'description', 'created_at', 'updated_at'])
            ->where(['catalog_id' => $id])
            ->where('name', 'ILIKE', "%$value%") // нечувствительность к регистру
            ->get();
    }

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

    public function changeStatus($id, $mark)
    {
        DB::table('tasks')
            ->where('id', $id)
            ->update(['done' => $mark]);
        return Task::find($id);
    }

    public function deleteTask($id)
    {
        return DB::table('tasks')
            ->where('id', $id)
            ->delete();

    }
}
