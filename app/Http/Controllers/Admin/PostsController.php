<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use App\Category;
use Validator;
use Response;
use App\Post;
use Auth;
use Str;




class PostsController extends Controller
{
    private $PostRepository;
    private $CategoryRepository;

    public function __construct()
    {
        $this->PostRepository = app(PostRepository::class);
        $this->CategoryRepository = app(CategoryRepository::class);
    }

    public function index(Request $request)
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

        if ($request->get('paginateAll') == null) {

            $items = Post::select($columns)
                ->orderBy('id', 'DESC')
                ->with(['category:id,title,slug', 'user:id,first_name,sur_name,last_name'])
                ->paginate(25);
        } else {

            $items = Post::select($columns)
                ->orderBy('id', 'DESC')
                ->with(['category:id,title,slug', 'user:id,first_name,sur_name,last_name'])
                ->get();
        }

        return view('admin.posts.list', compact('items'));
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'post_title' => 'required',
            'post_text' => 'required',
            'category' => 'required',
        ], [
            'post_title.required' => 'Заголовок новости обязателен.',
            'post_text.required' => 'Новость без текста? Лучше все таки добавить.',
            'category.required' => 'Выберите рубрику для поста',
        ])->validate();

        if (!Post::where('category_id', $valid['category'])->where('title', $valid['post_title'])->exists()) {
            $post = new Post();

            $post->category_id = $valid['category'];
            $post->title = $valid['post_title'];
            $post->content_html = $valid['post_text'];
            $post->content_raw = $request['post_textRaw'];

            $post->slug = Str::slug($valid['post_title']);
            $post->user_id = Auth::user()->id;
            $excerpt_text = strip_tags(preg_replace("/<img[^>]+\>/i", "(image) ", $valid['post_text']));
            $post->excerpt = Str::words($excerpt_text, 20);
            $post->is_published = 1;
            $post->save();

            $category = Category::where('id', $valid['category'])->get();


            $res = ['url' => route('blog.posts.index') . "/" . $category[0]->slug . "/" . Str::slug($valid['post_title'])];
            return Response::json($res, 200);
        } else return abort(500, 'Пост с таким названием существует в этой категории');
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));
    }

    public function edit($id)
    {
        $item = $this->PostRepository->getEdit($id);
        $categories = Category::all();

        return view('admin.posts.edit', compact('item', 'categories'));
    }

    public function destroy(Post $post)
    {
        $result = $post->forceDelete();

        if ($result) {
            return redirect()
                ->route('admin.posts.index')
                ->with(['success' => 'Post Deleted.']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }


    public function update(Request $request, $id)
    {
        $item = Post::findOrFail($id);
        if (empty($item)) abort(404);

        $data = $request->all();
        $excerpt_text = strip_tags(preg_replace("/<img[^>]+\>/i", "(image) ", $data['content_html']));
        $data['excerpt'] = Str::words($excerpt_text, 20);
        $result = $item->update($data);
        $category = Category::where('id', $request['category_id'])->get();

        if ($result) {
            return Response::json([
                'url' => route('blog.posts.index') . "/" . $category[0]->slug . "/" . Str::slug($data['title']),
                'msg' => 'Успешно сохранено'
            ], 200);
        } else {
            return Response::json([
                'url' => route('blog.posts.index') . "/" . $category[0]->slug . "/" . Str::slug($data['title']),
                'msg' => 'Что-то пошло не так'
            ], 200);
        }
    }
}
