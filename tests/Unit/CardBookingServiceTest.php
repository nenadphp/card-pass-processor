<?php

namespace Tests\Unit;

use App\Models\Card;
use App\Models\CardBooking;
use App\Models\ObjectModel;
use App\Models\User;
use App\Services\Interfaces\CardProcessorInterface;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CardBookingServiceTest extends TestCase
{
    public function test_is_card_booked_success()
    {
        $object = ObjectModel::find(1);
        $user = User::find(1);
        $card = Card::create([
            'user_id'   => $user->id,
            'card_uuid' => Hash::make('test_card_name_is_success'),
            'is_active' => '1'
        ]);

        CardBooking::create([
            'object_id' => $object->id,
            'card_id' => $card->id,
            'created_at' => Carbon::today()
        ]);

        $isBooked = app(CardProcessorInterface::class)
            ->isBooked($object->object_uuid, $card->card_uuid);
        $this->assertTrue($isBooked);

        CardBooking::where('object_id', $object->id)
            ->where('card_id', $card->id)
            ->whereDay('created_at', Carbon::today())
            ->delete();

    }

    public function test_is_card_booked_fail()
    {
        $isBooked = app(CardProcessorInterface::class)
            ->isBooked(-1, -1);
        $this->assertFalse($isBooked);
    }
}
