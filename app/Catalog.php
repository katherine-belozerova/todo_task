<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use \DB;
use function GuzzleHttp\describe_type;

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
        $catalog->save();

        return response()->json($catalog);
    }

    public function updateCatalog(Request $request, $id)
    {
        $update = Catalog::find($id);
        $update->name = $request->input('name');

        $update->save();

        return response()->json($update);
    }

    public function changeStatus($id, $mark)
    {
        return DB::table('catalogs')
            ->where('id', $id)
            ->update(['done' => $mark]);
    }

    public function deleteCatalog($id)
    {
        return DB::table('catalogs')
            ->where('id', $id)
            ->delete();
    }



}
