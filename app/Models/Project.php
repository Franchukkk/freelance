<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

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
        'client_id',
        'title',
        'freelancer_id',
        'category',
        'description',
        'budget_min',
        'budget_max',
        'deadline',
        'status',
    ];


    public static function storeProject($data) {
        return Project::create($data);;
    }

    public static function editProject($data) {
        Project::where('id', $data['id'])
            ->update($data);
    }

    public static function getCustomerProjects($id) {
        return Project::where('client_id', $id)->get();
    }

    public static function setFreelancerAndChangeStatus($id, $freelancer_id) {
        Project::where('id', $id)
            ->update([
                'freelancer_id' => $freelancer_id,
                'status' => 'in progress',
                'updated_at' => now()
            ]);
    }

    public static function getFreelancerProjects($id) {
        return Project::where('freelancer_id', $id)->get();
    }

    public static function closeProject($id) {
        Project::where('id', $id)
            ->update([
                'status' => 'completed',
                'updated_at' => now()
            ]);
    }
}
