<?php
use Cake\Core\Plugin;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

Router::defaultRouteClass(DashedRoute::class);

// New route we're adding for our tagged action.
// The trailing `*` tells CakePHP that this action has
// passed parameters.

    Router::scope('/', function ($routes) {
        $routes->connect(
        '/',
        ['controller' => 'Users', 'action' => 'login']
    );

    Router::scope(
        '/articles',
        ['controller' => 'Articles'],
        function ($routes) {
            $routes->connect('/tagged/*', ['action' => 'tags']);
        }
    );

    // Connect the conventions based default routes.
    $routes->fallbacks();
});

Plugin::routes();
