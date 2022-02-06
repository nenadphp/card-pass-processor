<?php

namespace App\Services\Interfaces;

interface PasswordGeneratorInterface
{
    public function generate(): string;
}
