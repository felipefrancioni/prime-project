<?php

namespace SdcProject\Http\Middleware;

use Closure;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use SdcProject\Services\ProjectService;

class CheckProjectOwner {

    private $projectService;

    /**
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService) {
        $this->projectService = $projectService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!$this->projectService->isOwner($request->project, Authorizer::getResourceOwnerId())) {
            return ['error' => 'Access forbidden!'];
        }
        return $next($request);
    }
}
