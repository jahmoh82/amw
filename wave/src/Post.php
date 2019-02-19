<?php

namespace Wave;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function link(){
    	return url('/blog/' . $this->category->slug . '/' . $this->slug);
    }

    public function image(){
    	return \Voyager::image($this->image);
    }

    public function category(){
        return $this->belongsTo('Wave\Category');
    }

    public function author(){
        return $this->belongsTo('App\User');
    }
}
