<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovaPostArea extends Model
{
    protected $table = "nova_post_areas";
    protected $primaryKey = 'id';
    protected $fillable = [
        'ref',
        'name',
    ];
}
