<?php

namespace App\Services;

use App\Exceptions\MissingCardModelException;
use App\Exceptions\MissingObjectModelException;
use App\Models\Card;
use App\Models\CardBooking;
use App\Services\Interfaces\CardProcessorInterface;
use Carbon\Carbon;

class CardProcessorService implements CardProcessorInterface
{
    /**
     * @var CardBooking
     */
    private $cardModel;

    /**
     * @param Card $cardBooking
     */
    public function __construct(Card $cardBooking)
    {
        $this->cardModel = $cardBooking;
    }

    /**
     * @param string $objectUuid
     * @param string $cardUuid
     * @return bool
     */
    public function isBooked(string $objectUuid, string $cardUuid): bool
    {
        if ($this->cardModel->isBooked($objectUuid, $cardUuid)) {
            logger(
                sprintf(
                    'Card uuid: %s is already booked for date:%s',
                    $cardUuid, Carbon::today()->format('Y-m-d')
                )
            );

            return true;
        }

        return false;
    }

    /**
     * @param string $objectUuid
     * @param string $cardUuid
     * @return array
     * @throws MissingCardModelException
     * @throws MissingObjectModelException
     */
    public function book(string $objectUuid,string $cardUuid): array
    {
        if ($isBooked = $this->cardModel->book($objectUuid, $cardUuid)) {
            logger(
                sprintf('Card uuid: %s was booked at: %s', $cardUuid, Carbon::today()->toString())
            );
        }

        return $isBooked;
    }
}
