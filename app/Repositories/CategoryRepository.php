<?php

namespace App\Repositories;

use App\Category as Model;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id){
        return $this->startConditions()->find($id);
    }

    public function getForComboBox()
    {
        $columns =implode(', ', ['id', 'title']);

        $result = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;
    }

    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->paginate($perPage);

        return $result;
    }
}

