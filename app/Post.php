<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    public function thisIsUserObject(){

/*        Belongs to nes rysys - vienas user turi daug postu, vienas prie daug ->post.user_
        Antras argumentas stulpelio pavadinimas is lenteles post (nes cia modelis POST),
        pagal kuri prijungiam kita lentele App\User tai User modelis, t.y. lentele user*/

            return $this->belongsTo('App\User', 'user');
    }
    public function cat(){
        // kai rysys many to many - visada bus belongs to many

        return $this->belongsToMany('App\Category');
    }
    public function fileObject(){
        // vienas prie daug
        return $this->hasMany('App\File');
    }

}
