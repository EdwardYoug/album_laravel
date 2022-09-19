<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $table = 'albums';
    protected $guarded = false;

    /*
    * Настроить автоматическое форматирование в IDE по PSR4
    */
    public function photos() {
        return $this->hasMany(Photo::class, 'album_id', 'id');
    }
}
