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
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
            'created_at'
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
            ->with(['category:id,title,slug', 'user:id,first_name,sur_name,last_name'])
            ->paginate(25);

        return $result;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

}