<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
     use SoftDeletes;
    protected $fillable = ['nom','localisation','capacite','user_id','cuisine_id'];

    public function restaurateur() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cuisine() {
        return $this->belongsTo(Cuisine::class);
    }
    public function photos() {
        return $this->hasMany(Photo::class);
    }
    public function horaires() {
        return $this->hasMany(Horaire::class);
    }
    public function menu() {
        return $this->hasOne(Menu::class);
    }
    public function favoris() {
        return $this->belongsToMany(User::class, 'favoris');
    }
}
