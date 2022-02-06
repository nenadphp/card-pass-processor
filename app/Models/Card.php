<?php

namespace App\Models;

use App\Exceptions\MissingCardModelException;
use App\Exceptions\MissingObjectModelException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Card extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'card_uuid',
        'is_active'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param string $cardUuid
     * @return mixed
     */
    public function isCardValid(string $cardUuid)
    {
        return self::where('card_uuid', $cardUuid)
            ->where('is_active', '1')
            ->first();
    }

    /**
     * @param string $objectUuid
     * @param string $cardUuid
     * @return bool
     */
    public function isBooked(string $objectUuid,string $cardUuid): bool
    {
        $data = DB::table('cards')
            ->join('card_bookings', 'card_bookings.card_id', '=', 'cards.id')
            ->join('objects', 'objects.id', '=', 'card_bookings.object_id')
            ->where('cards.card_uuid', $cardUuid)
            ->where('objects.object_uuid', $objectUuid)
            ->whereDay('card_bookings.created_at', Carbon::today())
            ->first();

        return !is_null($data);
    }


    /**
     * @param string $objectUuid
     * @param string $cardUuid
     * @return array
     * @throws MissingCardModelException
     * @throws MissingObjectModelException
     */
    public function book(string $objectUuid, string $cardUuid): array
    {
        $card = self::where('card_uuid', $cardUuid)->first();
        $object = ObjectModel::where('object_uuid', $objectUuid)->first();

        if (is_null($card)) {
            logger(
                sprintf('System error, card with uuid: (%s) do not exist, aborting process', $cardUuid)
            );

            throw new MissingCardModelException();
        }

        if (is_null($object)) {
            logger(
                sprintf('System error, Object with uuid: (%s) do not exist, aborting process', $objectUuid)
            );

            throw new MissingObjectModelException();
        }

        CardBooking::create([
            'object_id' => $object->id,
            'card_id' => $card->id,
            'created_at' => Carbon::now()
        ]);

        return [
            'firstName' => $card->user->first_name,
            'lastName' => $card->user->last_name,
            'objectName' => $object->name,
        ];
    }
}
