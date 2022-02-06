<?php

namespace App\Services\Interfaces;

interface CardProcessorInterface
{
    /**
     * @param string $objectUuid
     * @param string $cardUuid
     * @return bool
     */
    public function isBooked(string $objectUuid, string $cardUuid): bool;

    /**
     * @param string $objectUuid
     * @param string $cardUuid
     * @return array
     */
    public function book(string $objectUuid, string $cardUuid): array;
}
