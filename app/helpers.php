<?php

if (!function_exists('public_path')) {
    function public_path($path = null)
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }
}

if (!function_exists('asset')) {
    function asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}

function resource($uri, $controller, $routeName = null)
{
    $route = app('router');

    if ($routeName) {
        $route->get($uri, ['as' => $routeName . '.index', 'uses' => $controller . '@index']);
        $route->get($uri . '/create', ['as' => $routeName . '.create', 'uses' => $controller . '@create']);
        $route->post($uri, ['as' => $routeName . '.store', 'uses' => $controller . '@store']);
        $route->get($uri . '/{id}', ['as' => $routeName . '.show', 'uses' => $controller . '@show']);
        $route->get($uri . '/{id}/edit', ['as' => $routeName . '.edit', 'uses' => $controller . '@edit']);
        $route->put($uri . '/{id}', ['as' => $routeName . '.update', 'uses' => $controller . '@update']);
        $route->delete($uri . '/{id}', ['as' => $routeName . '.destroy', 'uses' => $controller . '@destroy']);
    } else {
        $route->get($uri, $controller . '@index');
        $route->get($uri . '/create', $controller . '@create');
        $route->post($uri, $controller . '@store');
        $route->get($uri . '/{id}', $controller . '@show');
        $route->get($uri . '/{id}/edit', $controller . '@edit');
        $route->put($uri . '/{id}', $controller . '@update');
        $route->delete($uri . '/{id}', $controller . '@destroy');
    }
}
