<?php

namespace App\Http\Controllers;

use App\Catalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Отображение всех списков дел и их отметок выполненности конкретного пользователя
     *
     * @param $id integer id пользователя, чьи списки хотим посмотреть
     * @return array
     */

    public function catalogs($id)
    {
        $model = new Catalog();
        return $model->showMyCatalogs($id);
    }

    /**
     * Отображение всех невыполненных списков дел
     *
     * @param $id integer id пользователя, чьи невыполненные списки хотим посмотреть
     * @var $done boolean данная переменная необходима, т.к для просмотра выполненных и не выполненных списков
     * используется один и тот же метод findByDone, который принимает в качестве входного параметра переменную $done
     * @return array
     */

    public function notCompleted($id)
    {
        $model = new Catalog();
        return $model->findByDone($id, $done = false);
    }

    /**
     * Сортировка выполненных дел
     *
     * @param $id integer id пользователя, чьи выполненные списки дел хотим отсортировать
     * @param $field string поле БД, по которому хотим выполнить сортировку
     * @var $type string тип сортировки (в данном случае ASC)
     * @var $done boolean как и в случае выше, данная переменная необходима т.к. для сортировки выполненных и не выполненных списков
     * используется один и тот же метод sortingBy
     * @return array
     */

    public function sortingByCompleted($id, $field)
    {
        $model = new Catalog();
        return $model->sortingBy($id, $field, $type = 'asc', $done = true);
    }

    /**
     * Сортировка невыполненных дел
     *
     * Логика идентична sortingByCompleted($id, $field)
     *
     * @param $id integer
     * @param $field string
     * @var $type string
     * @var $done boolean
     * @return array
     */

    public function sortingByNotCompleted($id, $field)
    {
        $model = new Catalog();
        return $model->sortingBy($id, $field, $type = 'asc', $done = false);
    }

    /**
     * Поиск по всем спискам дел пользователя
     *
     * @param $id integer id пользователя, в чьих списках в данный момент осуществляется поиск
     * @param $value string непосредственно сам запрос поиска, например "Сходить в магазин"
     * @return array
     */

    public function searching($id, $value)
    {
        $model = new Catalog();
        return $model->search($id, $value);
    }

    /**
     * Отображение всех выполненных списков дел
     *
     * Логика идентична notCompleted($id)
     *
     * @param $id integer
     * @var $done boolean
     * @return array
     */

    public function completed($id)
    {
        $model = new Catalog();
        return $model->findByDone($id, $done = true);
    }

    /**
     * Создание нового списка
     *
     * @param Request $request
     * @param $id integer id пользователя, который создает новый список дел
     * @return Catalog|JsonResponse
     */

    public function create(Request $request, $id)
    {
        $model = new Catalog();
        return $model->createNewCatalog($request, $id);
    }

    /**
     * Редактирование списка дел
     *
     * @param Request $request
     * @param $id integer id списка дел, который необходимо изменить
     * @return Catalog|JsonResponse
     */

    public function update(Request $request, $id)
    {
        $model = new Catalog();
        return $model->updateCatalog($request, $id);
    }

    /**
     * Отметить список дел выполненным
     *
     * @param $id integer id списка дел, который необходимо отметить как выполненный
     * @var $mark boolean отметка выполненности, в данном случае $mark = true
     * @return Catalog|JsonResponse
     */

    public function done($id)
    {
        $model = new Catalog();
        return $model->changeStatus($id, $mark = true);

    }

    /**
     * Отметить список дел, как невыполненный
     *
     * @param $id integer id списка дел, который необходимо отметить как невыполненный
     * @var $mark boolean отметка выполненности, в данном случае $mark = false
     * @return Catalog|JsonResponse
     */

    public function notDone($id)
    {
        $model = new Catalog();
        return $model->changeStatus($id, $mark = false);
    }

    /**
     * Удаление списка дел
     *
     * Если удалить список дел, то удалятся и все вложенные в него дела
     *
     * @param $id integer id удаляемого списка дел
     * @return string
     */

    public function delete($id)
    {
        $model = new Catalog();
        return $model->deleteCatalog($id);
    }

}
