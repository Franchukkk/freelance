<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Bid extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bids';

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
        'freelancer_id',
        'bid_amount',
        'deadline_time',
        'message',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get bids by project ID with freelancer information.
     *
     * @param int $id Project ID
     * @return Collection Collection of bids with freelancer names
     */
    public static function getBidsByProjectId($id)
    {
        $projects =  Bid::where('project_id', $id)->get();

        foreach ($projects as $project) {
            $project->freelancer = User::getById($project->freelancer_id)->name . ' ' . User::getById($project->freelancer_id)->surname;
        }

        return $projects;
    }
}
