<?php

    namespace SdcProject\Http\Middleware;

    use Closure;
    use LucaDegasperi\OAuth2Server\Facades\Authorizer;
    use SdcProject\Services\ProjectService;

    class CheckProjectPermission {

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
            $projectId = $request->route('projectId') ? $request->route('projectId') : $request->route('project');

            if (!$this->projectService->checkProjectPermissions($projectId)) {
                return ['error' => 'Você não tem permissão para acessar o projeto!'];
            }
            return $next($request);
        }
    }
