<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class message extends Model
{
    use HasFactory;
    protected $fillable = ['title','content','from_user_id','to_user_id'];

    /**
     * Get the user that owns the message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    public function to_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }
}
