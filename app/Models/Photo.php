<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $table = 'photos';
    protected $guarded = false;

    /*
     * Настроить автоматическое форматирование в IDE по PSR4
     */

    public function album() {
        return $this->belongsTo(Album::class, 'album_id','id');
    }
}
