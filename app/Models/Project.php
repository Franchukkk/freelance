<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use \Illuminate\Database\Eloquent\Collection;


class Project extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;
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

    /**
     * Store a new project.
     *
     * @param array $data
     * @return Project
     */
    public static function storeProject($data) {
        return Project::create($data);;
    }

    /**
     * Edit an existing project.
     *
     * @param array $data
     * @return void
     */
    public static function editProject($data) {
        $project = Project::where('id', $data['id'])->first();
        $project->update($data);
    }

    /**
     * Assign a freelancer to a project and update its status.
     *
     * @param int $id
     * @param int $freelancer_id
     * @return void
     */
    public static function setFreelancerAndChangeStatus($id, $freelancer_id) {
        Project::where('id', $id)
            ->update([
                'freelancer_id' => $freelancer_id,
                'status' => 'in progress',
                'updated_at' => now()
            ]);
    }

    /**
     * Get all projects for a specific freelancer.
     *
     * @param int $id
     * @return Collection
     */
    public static function getFreelancerProjects($id) {
        return Project::where('freelancer_id', $id)->get();
    }

    /**
     * Mark a project as completed.
     *
     * @param int $id
     * @return void
     */
    public static function closeProject($id) {
        Project::where('id', $id)
            ->update([
                'status' => 'completed',
                'updated_at' => now()
            ]);
    }
}
