<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = array('title', 'category_id','content_html', 'excerpt');
	protected $appends = [
		'path',
	];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function getPathAttribute()
	{
		return route('showPost', ['categorySlug' => $this->category->slug, 'postSlug' => $this->slug]);
	}
}
