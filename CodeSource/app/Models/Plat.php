<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plat extends Model {
    protected $fillable = ['content','prix_uni','menu_id'];
    public function menu() {
        return $this->belongsTo(Menu::class);
    }
}
