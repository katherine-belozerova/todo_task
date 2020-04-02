<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Lists extends Model
{
    const DONE = 't'; // boolean true
    const NOT_DONE = 'f'; // boolean false

    protected $table = 'list';
    protected $primaryKey = 'list_id';
    protected $fillable = ['list_name', 'user_id'];

    public $list_name;
    public $user_id;
    public $mark_done;

    public function showMyLists($user_id)
    {
        return DB::table('list')
            ->pluck('list_name', 'mark_done', 'created_at', 'updated_at')
            ->where('user_id', $user_id)
            ->get();
    }

    public function createNewList(Request $request, $user_id)
    {
        $list = new Lists();
        $list->list_name = $request->list_name;
        $list->user_id = $user_id;

        $list->save();

        return response()->json($list);
    }

    public function updateList(Request $request, $list_id)
    {
        $list = Lists::find($list_id);
        $list->list_name = $request->input('list_name');

        $list->save();

        return response()->json($list);
    }

    public function changeStatus($list_id, $mark)
    {
       return DB::table('list')
            ->update(['mark_done' => $mark])
            ->where('list_id', $list_id)
            ->put();
    }

    public function deleteList($list_id)
    {
        return DB::table('list')
            ->where('list_id', $list_id)
            ->delete()
            ->post();
    }

}
