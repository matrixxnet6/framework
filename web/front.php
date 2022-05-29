<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;
use Simplex\StringResponseListener;

$routes = include __DIR__.'/../src/app.php';
$container = include __DIR__.'/../src/container.php';

$container->register('listener.string_response', StringResponseListener::class);
$container->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', [new Reference('listener.string_response')])
;

$request = Request::createFromGlobals();

$response = $container->get('framework')->handle($request);

$response->send();
