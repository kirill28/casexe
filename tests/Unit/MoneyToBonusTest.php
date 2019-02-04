<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Prizable\BonusPointPrize;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MoneyToBonusTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $requiredValue = null;
        $moneyValue = 5;
        $coefficient = 3.5;

        $prize = new BonusPointPrize();

        //change protected property
        $reflection = new \ReflectionClass($prize);
        $property = $reflection->getProperty('moneyToBonusPointsCoefficient');
        $property->setAccessible(true);
        $property->setValue($prize, $coefficient);
        $property->setAccessible(false);


        $user = $this->createMock(User::class);
        $user->method('addBonusPoints')->willReturnCallback(function ($value) use (&$requiredValue) {
            $requiredValue = $value;
            return true;
        });
        $user->method('save')->willReturn(true);

        \Auth::setUser($user);

        $prize->convertFromMoney($moneyValue);

        $this->assertEquals($requiredValue, $moneyValue * $coefficient);
    }
}
