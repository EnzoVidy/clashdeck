<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deck extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'is_public', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'card_deck');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}