<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;

class PostsController extends Controller
{
    private $PostRepository;
    private $CategoryRepository;

    public function __construct()
    {
        $this->PostRepository = app(PostRepository::class);
        $this->CategoryRepository = app(CategoryRepository::class);
    }

    public function index()
    {
        $posts = $this->PostRepository->getAllWithPaginate();

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {

    }

    public function edit($id)
    {
        $item = $this->PostRepository->getEdit($id);
        $categoryList = $this->CategoryRepository->getForComboBox();

        return view('admin.posts.edit', compact('item', 'categoryList'));
    }

}