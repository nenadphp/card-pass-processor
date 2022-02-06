<?php

namespace App\Http\Middleware;

use App\Models\ObjectModel;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class isObjectValidMiddleware
{
    /**
     * @var Object
     */
    private $objectModel;

    /**
     * @param ObjectModel $object
     */
    public function __construct(ObjectModel $object)
    {
        $this->objectModel = $object;
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
        if(!$this->objectModel->isObjectValid($request->get('object_uuid'))) {
            logger(
                sprintf('Invalid object passed, Object ID: %s', $request->get('object_uuid'))
            );

            return \response('Object forbidden', 403);
        }

        return $next($request);
    }
}
