<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SystemOption
 *
 * @property string $name
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemOption whereValue($value)
 * @mixin \Eloquent
 */
class SystemOption extends Model
{
    const BONUS_POINTS_MIN_VALUE = 'bonus_points_min_value';
    const BONUS_POINTS_MAX_VALUE = 'bonus_points_max_value';
    const MONEY_TO_BONUS_POINTS_COEFFICIENT = 'money_to_bonus_points_coefficient';
    const MONEY_MIN_VALUE = 'money_min_value';
    const MONEY_MAX_VALUE = 'money_max_value';
    const PRIVAT_BANK_MERCHANT_ID = 'privat_bank_merchant_id';
    const PRIVAT_BANK_MERCHANT_PASSWORD = 'privat_bank_merchant_password';
    const PRIVAT_BANK_ENABLE_PAYMENTS = 'privat_bank_enable_payments';

    protected $fillable = [
        'name',
        'value',
    ];

    /**
     * @param array $optionNames
     * @return array
     */
    public static function getValues(array $optionNames): array
    {
        return static::whereIn('name', $optionNames)
            ->pluck('value', 'name')->toArray();
    }

    /**
     * @param string $optionName
     * @return string
     */
    public static function getValue(string $optionName): string
    {
        return static::where('name', $optionName)
            ->pluck('value')
            ->first();
    }
}
