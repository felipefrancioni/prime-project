<?php

    namespace SdcProject\Http;

    use Illuminate\Foundation\Http\Kernel as HttpKernel;
    use SdcProject\Http\Middleware\CheckProjectOwner;
    use SdcProject\Http\Middleware\CheckProjectPermission;

    class Kernel extends HttpKernel {
        /**
         * The application's global HTTP middleware stack.
         *
         * @var array
         */
        protected $middleware = [
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
            \SdcProject\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \LucaDegasperi\OAuth2Server\Middleware\OAuthExceptionHandlerMiddleware::class,
        ];

        /**
         * The application's route middleware.
         *
         * @var array
         */
        protected $routeMiddleware = [
            'auth' => \SdcProject\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'guest' => \SdcProject\Http\Middleware\RedirectIfAuthenticated::class,
            'csrf' => \SdcProject\Http\Middleware\VerifyCsrfToken::class,
            'oauth' => \LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware::class,
            'oauth-user' => \LucaDegasperi\OAuth2Server\Middleware\OAuthUserOwnerMiddleware::class,
            'oauth-client' => \LucaDegasperi\OAuth2Server\Middleware\OAuthClientOwnerMiddleware::class,
            'check-authorization-params' => \LucaDegasperi\OAuth2Server\Middleware\CheckAuthCodeRequestMiddleware::class,
            'check-project-owner' => CheckProjectOwner::class,
            'check-project-permission' => CheckProjectPermission::class
        ];
    }
