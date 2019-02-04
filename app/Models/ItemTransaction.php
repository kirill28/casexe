<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\ItemTransaction
 *
 * @property int $id
 * @property int $item_id
 * @property int $user_id
 * @property string $status
 * @property string|null $info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemTransaction whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemTransaction whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ItemTransaction whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Item $item
 * @property-read \App\Models\User $user
 */
class ItemTransaction extends Model
{
    const STATUS_WAITING = 'waiting';
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    protected $fillable = [
        'item_id',
        'user_id',
        'status',
        'info',
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function item(): HasOne
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
}
