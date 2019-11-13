<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;
use App\Post;
use App\CatalogPost;

class Search extends Component
{
    public $searchTerm;
    public $users;
    public $posts;
    public $catalogPosts;

    public function render()
    {
        $strSearch = "%" . $this->searchTerm . "%";
        $this->users = User::select('id', 'name', 'mobile_phone', 'work_phone', 'position')->where('name', 'like', $strSearch)
            ->orWhere('mobile_phone', 'like', $strSearch)
            ->orWhere('work_phone', 'like', $strSearch)
            ->orWhere('position', 'like', $strSearch)

            ->get()->toArray();

        $this->posts = Post::select('title', 'slug', 'category_id')->where('title', 'like', $strSearch)->with('category:id,title,slug')->get()->toArray();
        // $this->postsCatalog = CatalogPost::select()->where('title', $strSearch)->get()->toArray();

        return view('livewire.search');
    }
}
