<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
    	'user_id',
    	'news_category_id',
    	'title',
    	'short_description',
    	'full_content',
    	'thumbnail',
    	'thumbnail_caption',
    	'is_publish',
    ];

    protected $hidden = [
        'user_id', 'news_category_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function newsCategory()
    {
        return $this->belongsTo('App\Models\NewsCategory');
    }

    public function storeNews($data)
    {
    	return News::create($data);
    }

    public function showNews()
    {
    	return News::with(['user','newsCategory'])
            ->get();
    }

    public function getNews($id)
    {
        return News::with(['user','newsCategory'])
            ->find($id);
    }

    public function updateNews($data, $id)
    {
        return News::where('id',$id)->update($data);
    }

    public function deleteNews($id)
    {
        News::where('id', $id)->delete();
    }
}
