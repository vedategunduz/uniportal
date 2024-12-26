<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editor extends Model
{
    protected $table = 'editor';

    protected $primaryKey = 'editor_id';

    protected $casts = [
        'icerik' => 'array',
    ];

    protected $fillable = [
        'icerik',
    ];
}
