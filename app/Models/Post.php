<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
        protected $fillable=[
                'title',
                'slug',
                'excerpt',
                'content',
                'featured_image',
                'meta_title',
                'meta_description',
                'status',
                'published_at',
                'category_id',
                'branch_id'
        ];

        public function category()
        {
            return $this->belongsTo(Category::class);
        }


        public function tags()
        {
            return $this->belongsToMany(Tag::class);
        }


}
