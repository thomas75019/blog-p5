<?php
// set up composer autoloader
require __DIR__ . '/vendor/autoload.php';
use Blog\Service\ControllerFactory;

// create a server request object
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

// create the router container and get the routing map
$routerContainer = new Aura\Router\RouterContainer();
$map = $routerContainer->getMap();

//Home Route
$map->get('blog.home', '/', function () {
    $controller = ControllerFactory::newController('article');
    $controller->getAll();
});
//View One route
$map->get('blog.viewOne', '/read/{slug}', function ($request) {
    $slug = (string) $request->getAttribute('slug');
    $controller = ControllerFactory::newController('article');

    $controller->getOneBySlug($slug);
});
//Contact get Route
$map->get('blog.contact', '/contact', function () {
    $response = new Zend\Diactoros\Response();
    $response->getBody()->write("Contact form will go here");
    return $response;
});



// get the route matcher from the container ...
$matcher = $routerContainer->getMatcher();

// .. and try to match the request to a route.
$route = $matcher->match($request);
if (! $route) {
    echo "No route found for the request.";
    http_response_code(404);
    exit;
}

// add route attributes to the request
foreach ($route->attributes as $key => $val) {
    $request = $request->withAttribute($key, $val);
}

// dispatch the request to the route handler.
// (consider using https://github.com/auraphp/Aura.Dispatcher
// in place of the one callable below.)
$callable = $route->handler;
$response = $callable($request);

