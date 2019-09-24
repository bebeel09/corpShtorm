<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    #ЭТОТ КОНТРОЛЛЕР НЕ ИСПОЛЬЗУЕТСЯ ВРОДЕ КАК, Я НЕ УВЕРЕН.....
    public function index($slug)
    {
        // dump($slug);
        $category_id = Category::where('slug', $slug)->pluck('id');
        $category =  Category::where('id', $category_id)->first();
        $posts = Post::where('is_published', 1)->where('category_id', $category_id)->paginate(10);
        $categories = Category::all('title', 'slug');
        return view('category', [
            'posts' => $posts,
            'categories' => $categories,
            'category' => $category,
        ]);
    }
    #ЭТОТ КОНТРОЛЛЕР НЕ ИСПОЛЬЗУЕТСЯ ВРОДЕ КАК, Я НЕ УВЕРЕН.....
    #ЭТОТ КОНТРОЛЛЕР НЕ ИСПОЛЬЗУЕТСЯ ВРОДЕ КАК, Я НЕ УВЕРЕН.....
    #ЭТОТ КОНТРОЛЛЕР НЕ ИСПОЛЬЗУЕТСЯ ВРОДЕ КАК, Я НЕ УВЕРЕН.....
    #ЭТОТ КОНТРОЛЛЕР НЕ ИСПОЛЬЗУЕТСЯ ВРОДЕ КАК, Я НЕ УВЕРЕН.....
    #ЭТОТ КОНТРОЛЛЕР НЕ ИСПОЛЬЗУЕТСЯ ВРОДЕ КАК, Я НЕ УВЕРЕН.....
    #ЭТОТ КОНТРОЛЛЕР НЕ ИСПОЛЬЗУЕТСЯ ВРОДЕ КАК, Я НЕ УВЕРЕН.....



    public function store(Request $request)
    {
        $category = new Category();
        $category->title = $request->newCategoryName;
        $category->slug = Str::slug($request->newCategoryName);
        $category->parent_id = $request->newCategoryParent;
        $category->type_id = $request->typeCategory;
        if ($category->save()) {
            $res = ['categoryName' => $request->newCategoryName, 'categoryId' => $category->id];
            return Response::json($res, 200);
        }
    }
}
