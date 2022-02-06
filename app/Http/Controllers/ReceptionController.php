<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardProcessorRequest;
use App\Services\Interfaces\CardProcessorInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class ReceptionController extends Controller
{
    /**
     * @param CardProcessorRequest $request
     * @param CardProcessorInterface $cardProcessor
     * @return Application|ResponseFactory|Response
     * @throws Exception
     */
    public function cardReception(CardProcessorRequest $request, CardProcessorInterface $cardProcessor): Response
    {
        try {
            $objectUuid = $request->get('object_uuid');
            $cardUuid = $request->get('card_uuid');

            if ($cardProcessor->isBooked($objectUuid, $cardUuid)) {
                return response(
                    sprintf('Card uuid: %s is already booked for date :%s. Aborting....',
                        $cardUuid,
                        Carbon::today()->toString()
                    ),
                    403
                );
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
