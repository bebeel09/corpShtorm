<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Post;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Str;


class CategoryController extends Controller
{
    private $CategoryRepository;

    public function __construct()
    {
        $this->CategoryRepository = app(CategoryRepository::class);
    }

    public function index()
    {
        $categories = $this->CategoryRepository->getAllWithPaginate(5);
        $posts_count = [];

        foreach ($categories as $category) {
            $posts_count += [
                $category->title => Post::where('category_id', $category->id)->count()
            ];
        }

        return view('admin.categories', compact('categories', 'posts_count'));
    }

    public function edit($id)
    {
        $item = $this->CategoryRepository->getEdit($id);
        $categoryList = $this->CategoryRepository->getForComboBox();

        return view('admin.category.edit', compact('item', 'categoryList'));
    }

    public function update(Request $request, $id)
    {
        $item = $this->CategoryRepository->getEdit($id);
        if (empty($item)) {
            return back();
        }

        $title = $request->input('title');
        $parent_id = $request->input('parent_id');
        $slug = Str::slug($title);

        $result = $item->fill(array(
            'title' => $title,
            'parent_id' => $parent_id,
            'slug' => $slug
        ))->save();

        if ($result) {
            return redirect()
                ->route('admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    public function create()
    {
        $item = new Category();
        $categoryList = $this->CategoryRepository->getForComboBox();

        return view('admin.category.edit', compact('item', 'categoryList'));
    }

    public function store(Request $request)
    {
        $data = $request->input();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $item = (new Category())->create($data);

        if ($item) {
            return redirect()->route('admin.categories.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }
}
