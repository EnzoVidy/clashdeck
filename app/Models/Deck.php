<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'is_public', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cards() {
        return $this->belongsToMany(Card::class);
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }
}
