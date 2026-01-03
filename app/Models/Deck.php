<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deck extends Model
{
    use HasFactory;

    // Champs autorisés pour la création
    protected $fillable = ['title', 'description', 'is_public', 'user_id'];

    // Relation : Un Deck appartient à un User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relation : Un Deck possède plusieurs Cards
    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'card_deck');
    }
}
