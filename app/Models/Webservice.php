<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Webservice extends Model
{
    use HasFactory;

    /**
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * transactions model relation
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
