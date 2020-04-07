<?php

namespace App\Http\Controllers;

use App\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // Отображение всех списков дел и их отметок выполненности конкретного пользователя
    public function catalogs($id)
    {
        $model = new Catalog();
        return $model->showMyCatalogs($id);
    }

    // Отображение всех невыполненных списков дел
    public function notCompleted($id)
    {
        $model = new Catalog();
        return $model->findByDone($id, $done = false);
    }

    // Сортировка выполненных дел
    public function sortingByCompleted($id, $field)
    {
        $model = new Catalog();
        return $model->sortingBy($id, $field, $type = 'asc', $done = true);
    }

    // Сортировка невыполненных дел
    public function sortingByNotCompleted($id, $field)
    {
        $model = new Catalog();
        return $model->sortingBy($id, $field, $type = 'asc', $done = false);
    }

    // Поиск по всем спискам
    public function searching($id, $value)
    {
        $model = new Catalog();
        return $model->search($id, $value);
    }

    // Отображение всех выполненных списков дел
    public function completed($id)
    {
        $model = new Catalog();
        return $model->findByDone($id, $done = true);
    }

    // Создание нового списка
    public function create(Request $request, $id)
    {
        $model = new Catalog();
        return $model->createNewCatalog($request, $id);
    }

    // Редактирование списка
    public function update(Request $request, $id)
    {
        $model = new Catalog();
        return $model->updateCatalog($request, $id);
    }

    // Отметка выполненности
    public function done($id)
    {
        $model = new Catalog();
        return $model->changeStatus($id, $mark = true);
    }

    public function notDone($id)
    {
        $model = new Catalog();
        return $model->changeStatus($id, $mark = false);
    }

    public function delete($id)
    {
        $model = new Catalog();
        return $model->deleteCatalog($id);
    }

}
