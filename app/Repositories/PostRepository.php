<?php

namespace App\Repositories;

use App\Post as Model;

class PostRepository extends CoreRepository
{
    protected function getModelClass()
    {
       return Model::class;
    }

    public function getAllWithPaginate()
    {
        $columns = [
            'id',
            'title',
            'is_published',
            'published_at',
            'user_id',
            'category_id'
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
            ->with(['category:id,title', 'user:id,name'])
            ->paginate(25);

        return $result;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

}