<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovaPostDistrict extends Model
{
    protected $table = "nova_post_districts";
    protected $primaryKey = 'id';
    protected $fillable = [
        'area_id',
        'ref',
        'name',
    ];
}
