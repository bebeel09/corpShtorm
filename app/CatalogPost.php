<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogPost extends Model
{
    protected $fillable = array('title', 'catalog_id','content_json', 'excerpt');

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
