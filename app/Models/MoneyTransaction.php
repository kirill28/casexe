<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\MoneyTransaction
 *
 * @property int $id
 * @property int $user_id
 * @property string $status
 * @property float $amount
 * @property string $currency
 * @property string $card_number
 * @property string $info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyTransaction whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 */
class MoneyTransaction extends Model
{
    const STATUS_WAITING = 'waiting';
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    protected $fillable = [
        'user_id',
        'status',
        'amount',
        'currency',
        'card_number',
        'info',
    ];

    protected $casts = [
        'info' => 'array',
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
