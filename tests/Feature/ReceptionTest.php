<?php

namespace Tests\Feature;

use App\Models\Card;
use App\Models\CardBooking;
use App\Models\ObjectModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReceptionTest extends TestCase
{
    /**
     * @return void
     */
    public function test_reception_card_booking_success()
    {
        $object = ObjectModel::find(1);
        $user = User::find(1);
        $card = Card::create([
            'user_id'   => $user->id,
            'card_uuid' => Hash::make('test_card_name'),
            'is_active' => '1'
        ]);

        $response = $this->get("/api/reception?object_uuid={$object->object_uuid}&card_uuid={$card->card_uuid}");

        $response->assertExactJson([
            'data' => [
                'firstName' => $user->first_name,
                'lastName' => $user->last_name,
                'objectName' => $object->name,
            ]
        ]);

        $response->assertStatus(200);
        CardBooking::where('object_id', $object->id)
            ->where('card_id', $card->id)
            ->whereDay('created_at', Carbon::today())
            ->first()
            ->delete();

        Card::destroy($card->id);
    }

    /**
     * @return void
     */
    public function test_reception_card_booking_card_forbidden()
    {
        $object = ObjectModel::find(1);
        $user = User::find(1);
        $card = Card::create([
            'user_id'   => $user->id,
            'card_uuid' => Hash::make('test_card_name'),
            'is_active' => '0'
        ]);

        $response = $this->get("/api/reception?object_uuid={$object->object_uuid}&card_uuid={$card->card_uuid}");
        $response->assertSeeText('Invalid card');
        $response->assertStatus(403);
        Card::destroy($card->id);
    }

    /**
     * @return void
     */
    public function test_reception_card_booking_object_forbidden()
    {
        $card = Card::find(1);
        $object = ObjectModel::create([
            'object_uuid' => Hash::make('test_object_name'),
            'name' => 'Test object name',
            'is_active' => '0'
        ]);

        $response = $this->get("/api/reception?object_uuid={$object->object_uuid}&card_uuid={$card->card_uuid}");
        $response->assertSeeText('Invalid object');
        $response->assertStatus(403);
        ObjectModel::destroy($object->id);
    }
}
