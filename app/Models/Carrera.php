<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Testing\Fluent\Concerns\Has;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'
    ];

    public function materias(): HasMany
    {
        return $this->hasMany(Materia::class);
    }
}
