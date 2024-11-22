<?php

namespace Azuriom\Plugin\CommunityTube\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;

class CommunityTubeServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [
        // \Azuriom\Plugin\CommunityTube\Middleware\ExampleMiddleware::class,
    ];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     */
    protected array $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\CommunityTube\Middleware\ExampleRouteMiddleware::class,
    ];

    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [
        // User::class => UserPolicy::class,
    ];

    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        // $this->registerMiddleware();

        //
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        Permission::registerPermissions([
            'communitytube.manage' => 'communitytube::messages.permissions.manage',
            'communitytube.bypass_verification' => 'communitytube::messages.permissions.bypass',
            'communitytube.submit' => 'communitytube::messages.permissions.submit',
            'communitytube.set_video_author' => 'communitytube::messages.permissions.author',
        ]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            'communitytube.index' => trans('communitytube::messages.title'),
        ];

    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array<string, array<string, string>>
     */
    protected function adminNavigation(): array
    {
        return [
            'communitytube' => [
                'name' => 'CommunityTube',
                'type' => 'dropdown',
                'icon' => 'bi bi-youtube',
                'route' => 'communitytube.admin.*',
                'items' => [
                    'communitytube.admin.index' => trans('communitytube::messages.admin.nav.settings'),
                    'communitytube.admin.verif' => trans('communitytube::messages.admin.nav.verif'),
                ],
                'permission' => 'communitytube.manage'
            ]
        ];
    }

    /**
     * Return the user navigations routes to register in the user menu.
     *
     * @return array<string, array<string, string>>
     */
    protected function userNavigation(): array
    {
        return [
            //
        ];
    }
}
