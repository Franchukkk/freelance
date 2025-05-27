<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Message extends Model
{
    use HasFactory;
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

    /**
     * Get all messages for a specific user by their ID.
     *
     * @param int $user_id The ID of the user
     * @return Collection Collection of messages
     */
    public static function getMessagesByUserId($user_id)
    {
        return Message::where('sender_id', $user_id)->orWhere('receiver_id', $user_id)->get();
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
