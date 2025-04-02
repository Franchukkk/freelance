<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

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
        'sender_id',
        'receiver_id',
        'message',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function getMessagesByUserId($user_id)
    {
        return Message::where('sender_id', $user_id)->orWhere('receiver_id', $user_id)->get();
    }

}
