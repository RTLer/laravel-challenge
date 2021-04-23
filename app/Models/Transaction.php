<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    const TYPES = [
        'web' => 0,
        'mobile' => 1,
        'pos' => '2',
    ];

    /**
     *
     * @var array
     */
    protected $fillable = [
        'webservice_id',
        'amount',
        'type',
    ];

    /**
     * webservice model relation
     *
     * @return BelongsTo
     */
    public function webservice(): BelongsTo
    {
        return $this->belongsTo(Webservice::class);
    }
}
