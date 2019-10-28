<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CatalogPost;
use App\Catalog;
use Storage;
use Illuminate\Support\Str;
use Response;
use Auth;

class CatalogPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'catalog_id',
            'created_at'
        ];

        if ($request->get('paginateAll') == null) {

            $catalogs = CatalogPost::select($columns)
                ->orderBy('id', 'DESC')
                ->with(['catalog:id,title,slug', 'user:id,first_name,sur_name,last_name'])
                ->paginate(25);
        } else {
            $catalogs = CatalogPost::select($columns)
                ->orderBy('id', 'DESC')
                ->with(['catalog:id,title,slug', 'user:id,first_name,sur_name,last_name'])
                ->get();
        }

        return view('admin.catalog.list', compact('catalogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('create postsCatalog')){
            return redirect()->back()->with('status','У вас нет доступа для этого действия.');
        }

        $catalogs = Catalog::all();

        return view('admin.catalog.create', compact('catalogs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'files' => 'file',
            'post_title' => 'required',
            'catalog' => 'required'
        ], [
            'files.required' => 'Разрешаются файлы, картинки ...',
            'title.required' => 'Наличие заголовка обязательно',
            'catalog.required' => 'Каталог должен быть выбран'
        ]);

        $fileUrlJson = [];

        if (!CatalogPost::where([
            ['title', '=', $valid['post_title']],
            ['catalog_id', '=', $valid['catalog']]
        ])->exists()) {

            $savePath = 'public/Catalog/' . $valid["catalog"] . '_' . Str::slug($valid['post_title']);
            Storage::makeDirectory($savePath);

            foreach ($request->files as $file) {
                $originalName = date('U') . "_" . $file->getClientOriginalName();
                $path = Storage::putFileAs(
                    $savePath,
                    $file,
                    $originalName
                );

                array_push($fileUrlJson, $path);
            }

            $CatalogPost = new CatalogPost();

            $CatalogPost->catalog_id = $valid['catalog'];
            $CatalogPost->title = $valid['post_title'];
            $CatalogPost->content_json = json_encode($fileUrlJson);
            $CatalogPost->slug = Str::slug($valid['post_title']);
            $CatalogPost->user_id = Auth::user()->id;
            $CatalogPost->is_published = 1;

            $CatalogPost->save();

            $catalog = Catalog::where('id', $valid['catalog'])->first();

            $res = ['url' => route('catalogPost.show', ['catalogSlug' => $catalog->slug, 'catalogPostSlug' => Str::slug($valid['post_title'])])];
            return Response::json($res, 200);
        } else return abort(500, 'Пост с таким названием существует в этой категории');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('edit postsCatalog')){
            return redirect()->back()->with('status','У вас нет доступа для этого действия.');
        }
        $postCatalog = CatalogPost::where('id', $id)
            ->with(['catalog:id,title,slug'])
            ->first();
        $catalogs = Catalog::all();

        $filesPath = json_decode($postCatalog->content_json);

        return view('admin.catalog.edit', compact('postCatalog', 'filesPath', 'catalogs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valid = $request->validate([
            'files' => 'file',
            'post_title' => 'required',
            'catalog' => 'required'
        ], [
            'files.required' => 'Разрешаются файлы, картинки ...',
            'title.required' => 'Наличие заголовка обязательно',
            'catalog.required' => 'Каталог должен быть выбран'
        ]);

        $filesPath = []; //пути до файлов на сервере конкретно "поста" каталога
        $savePath = ""; //путь до дериктории "поста" каталога на сервере


        //удаляем файлы помеченные как удалённые
        $deleteFilesPath= json_decode($request->all()['dBasefilesPath']);
        foreach($deleteFilesPath as $file){
            if($file[1]==1) Storage::delete($file[0]);
        }

        $catalogPost = CatalogPost::where('id', $id)->first();

        $savePath = 'public/Catalog/' . $catalogPost->catalog_id . '_' . $catalogPost->slug;

        //сохраняем новые файлы от пользователя
        foreach ($request->file() as $file) {
            $originalName = date('U') . "_" . $file->getClientOriginalName();
            $path = Storage::putFileAs(
                $savePath,
                $file,
                $originalName
            );
        }
        
        $filesPath=Storage::allFiles($savePath);
        
        // если изменили название поста или пренадлежность к родителському каталогу
        if ($catalogPost->slug != Str::slug($valid['post_title']) || $catalogPost->catalog_id != $valid['catalog']) { 
            $newSavePath = 'public/Catalog/' . $valid['catalog'] . '_' . Str::slug($valid['post_title']);
            Storage::makeDirectory($newSavePath);

            //перекидываем файлы из старой в новую дерикторию
            foreach ($filesPath as $path) {
                $nameFile = substr($path, strripos($path, '/')+1);
                Storage::copy($savePath.'/'. $nameFile, $newSavePath .'/'. $nameFile);
            }
            Storage::deleteDirectory($savePath);

            $savePath=$newSavePath;
        }

        $filesPath=Storage::allFiles($savePath);

        $catalogPost->catalog_id = $valid['catalog'];
        $catalogPost->title = $valid['post_title'];
        $catalogPost->content_json = json_encode($filesPath);
        $catalogPost->slug = Str::slug($valid['post_title']);
        $catalogPost->user_id = Auth::user()->id;
        $catalogPost->is_published = 1;

        if ($catalogPost->save()) {

            $catalog = Catalog::where('id', $valid['catalog'])->first();

            $res = ['url' => route('catalogPost.show', ['catalogSlug' => $catalog->slug, 'catalogPostSlug' => $catalogPost->slug])];
            return Response::json($res, 200);
        }else return abort("500", "Не удалось сохранить изменения.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->hasPermissionTo('delete postsCatalog')){
            return redirect()->back()->with('status','У вас нет доступа для этого действия.');
        }

        $catalogPost=CatalogPost::find($id);

        $pathCatalogDirectory='public/Catalog/' . $catalogPost->catalog_id . '_' . $catalogPost->slug;
        Storage::deleteDirectory($pathCatalogDirectory);

        $catalogPost->delete();

        return redirect()
        ->route('admin.catalogPost.index')
        ->with(['success' => 'Каталог удалён.']);

    }

    public function addCatalog(Request $request)
    {
        $catalog = new Catalog();
        $catalog->title = $request->newCatalogName;
        $catalog->slug = Str::slug($request->newCatalogName);
        $catalog->parent_id = $request->newCatalogParent;
        if ($catalog->save()) {
            $res = ['catalogName' => $request->newCatalogName, 'catalogId' => $catalog->id];
            return Response::json($res, 200);
        }
    }
}
