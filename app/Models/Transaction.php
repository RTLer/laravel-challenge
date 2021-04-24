<?php

namespace App\Models;

use App\Filters\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 * @category Model
 *
 * @property int id
 * @property int webservice_id
 * @property int amount
 * @property int type
 * @property string type_name
 * @property int total
 * @property Carbon created_at
 *
 * @property Webservice webservice
 */
class Transaction extends Model
{
    use HasFactory, Filterable;

    const TYPES = [
        'web' => 0,
        'mobile' => 1,
        'pos' => 2,
    ];

    protected $dateFormat = 'Y-m-d H:i:s';
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

    /**
     * @return mixed|string
     */
    public function getTypeNameAttribute(): string
    {
        $flipTypes = array_flip(self::TYPES);

        return isset($flipTypes[$this->type]) ? $flipTypes[$this->type] : 'Unknown';
    }

    /**
     * @param $date
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        return Carbon::make($date)->format($this->dateFormat);
    }
}
