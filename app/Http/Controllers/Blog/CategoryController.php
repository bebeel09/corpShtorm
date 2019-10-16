<?php

namespace App\Http\Controllers\Blog;

use App\Category;
use App\BlogPost;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Response;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::with([
            'articles' => function ($articles) {
                return $articles->notDeleted();
            }
        ])->get();
        return view('blog.category.index', compact('categories'));
    }

    public function show(Request $request, $category)
    {

        $items = BlogPost::getPosts($request);
        $categories = BlogCategory::with([
            'articles' => function ($articles) {
                return $articles->notDeleted()->published();
            }
        ])->get();

        return view('blog.posts.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
            $category = new Category();

            $category->title = $request->newCategoryName;
            $category->slug = Str::slug($request->newCategoryName);
            $category->parent_id = $request->newCategoryParent;
            
            if ($category->save()) {
                $res = ['categoryName' => $request->newCategoryName, 'categoryId' => $category->id];
                return Response::json($res, 200);
            }

    }
}
