<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Letter extends Model
{
    use HasFactory; 
    protected $fillable = [ 'client_name', 'email', 'message', 'status', 'manager_id', 'answer', ];

}
