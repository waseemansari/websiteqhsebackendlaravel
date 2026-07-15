<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
        protected $appends = [
            'image_url'
        ];
        protected $fillable=[
                'title',
                'slug',
                'excerpt',
                'content',
                'featured_image',
                'meta_title',
                'meta_description',
                'meta_keywords',
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
            return $this->belongsToMany(Tag::class, 'post_tags');
        }


        public function getImageUrlAttribute()
        {
            if (!$this->featured_image) {
                return null;
            }

            return env('DO_SPACES_URL') .'/' . $this->featured_image;
        }


}
