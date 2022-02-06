<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardProcessRequest;
use App\Services\Interfaces\CardProcessorInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class ReceptionController extends Controller
{
    /**
     * @param CardProcessRequest $request
     * @param CardProcessorInterface $cardProcessor
     * @return Application|ResponseFactory|Response
     * @throws Exception
     */
    public function cardReception(CardProcessRequest $request, CardProcessorInterface $cardProcessor): Response
    {
        try {
            $objectUuid = $request->get('object_uuid');
            $cardUuid = $request->get('card_uuid');

            if ($cardProcessor->isBooked($objectUuid, $cardUuid)) {
                return response('Card is already booked for today.', 403);
            }

            return response([
                'data' => $cardProcessor->book($objectUuid, $cardUuid)
            ], 200);
        } catch (Exception $e) {
            logger(
                $error = sprintf('Card booking error: %s', $e->getMessage())
            );

            throw new Exception($error);
        }
    }
}
