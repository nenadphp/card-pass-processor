<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\PasswordGeneratorInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class PasswordGeneratorController extends Controller
{
    /**
     * @param PasswordGeneratorInterface $passwordGenerator
     * @return Application|ResponseFactory|Response
     */
    public function generate(PasswordGeneratorInterface $passwordGenerator): Response
    {
        return response(
            [
                'generated_password' => $passwordGenerator->generate()
            ],
            200
        );
    }
}
