<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'disputes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'project_id',
        'complainant_id',
        'respondent_id',
        'reason',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
