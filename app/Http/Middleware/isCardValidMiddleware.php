<?php

namespace App\Http\Middleware;

use App\Models\Card;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class isCardValidMiddleware
{
    /**
     * @var Card
     */
    private $cardModel;

    /**
     * @param Card $card
     */
    public function __construct(Card $card)
    {
        $this->cardModel = $card;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->cardModel->isCardValid($request->get('card_uuid'))) {
            logger(
                sprintf('Invalid card passed, CARD ID: %s', $request->get('card_uuid'))
            );

            return \response('Card forbidden', 403);
        }

        return $next($request);
    }
}
