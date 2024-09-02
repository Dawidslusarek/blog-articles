<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'slug'];

    public function user(): ?BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): ?HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
