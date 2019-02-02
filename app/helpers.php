<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 02.02.19
 * Time: 21:25
 */

/**
 * Returns cryptographic random or pseudorandom integer
 * @param int|null $min
 * @param int|null $max
 * @return int
 */
function crypto_rand_int(int $min = null, int $max = null): int
{
    $min = is_null($min) ? -mt_getrandmax() : $min;
    $max = is_null($max) ? mt_getrandmax() : $max;

    try {
        $value = random_int($min, $max);
    } catch (\Exception $exception) {
        \Log::warning('Random value isn\'t cryptographic random');
        $value = mt_rand($min, $max);
    }

    return $value;
}