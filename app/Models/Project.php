<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
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
        'category',
        'description',
        'budget_min',
        'budget_min',
        'deadline',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    public static function getAll() {
        return DB::table('projects')->get();
    }

    public static function getById($id) {
        return DB::table('projects')->where('id', $id)->first();
    }

    public static function storeProject($data) {
        return DB::table('projects')->insert($data);
    }

    public static function getCustomerProjects($id) {
        return DB::table('projects')->where('client_id', $id)->get();
    }

    public static function setFreelancerAndChangeStatus($id, $freelancer_id) {
        DB::table('projects')
            ->where('id', $id)
            ->update([
                'freelancer_id' => $freelancer_id,
                'status' => 'in progress',
                'updated_at' => now()
            ]);
    }

    public static function getFreelancerProjects($id) {
        return DB::table('projects')->where('freelancer_id', $id)->get();
    }
}
