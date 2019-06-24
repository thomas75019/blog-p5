<?php
// set up composer autoloader
require __DIR__ . '/vendor/autoload.php';
use Blog\Service\ControllerFactory;

session_start();

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
//Route for the creation
$map->get('article.create', '/create/article', function () {
    $controller = ControllerFactory::newController('article');
    $controller->create();
});
//Save Article Route
$map->post('article.save', '/save/article', function ($request) {
    $data = $request->getParsedBody();

    $controller = ControllerFactory::newController('article');
    $controller->save($data);
});
//render the register form
$map->get('user.register', '/register', function () {
    $controller = ControllerFactory::newController('utilisateur');

    $controller->register();
});
//Save new user in the database
$map->post('user.register.save', '/register', function ($request) {
    $data = $request->getParsedBody();

    $controller = ControllerFactory::newController('utilisateur');
    $controller->createUser($data);
});
//Login page
$map->get('user.login', '/login', function () {
    $controller = ControllerFactory::newController('utilisateur');

    $controller->loginPage();
});
//Login the user
$map->post('user.login.action', '/login', function ($request) {
    $data = $request->getParsedBody();
    $controller = ControllerFactory::newController('utilisateur');

    $controller->login($data);
});
//Logout
$map->get('user.logout', '/logout', function () {
    $controller = ControllerFactory::newController('utilisateur');

    $controller->logout();
});
//Get comments
$map->get('get.comments', '/admin/comments', function () {
    $controller = ControllerFactory::newController('commentaire');

    $controller->getAll();
});
//Save comment
$map->post('save.comment', '/save/comment/{article_id}', function ($request) {
    $articleId = $request->getAttribute('article_id');
    $auteur = unserialize($_SESSION['user']);
    $contenu = $request->getParsedBody();
    $controller = ControllerFactory::newController('commentaire');

    $controller->save($articleId, $auteur, $contenu);
});
//Valide comment
$map->put('valide.comment', '/valide/{commentaire_id}', function ($request) {
    $commentaire_id = $request->getAttribute('commentaire_id');
    $controller = ControllerFactory::newController('commentaire');

    $controller->setValide($commentaire_id);
});
//Invalide comment
$map->put('invalide.comment', '/invalide/{commentaire_id}', function ($request) {
    $commentaire_id = $request->getAttribute('commentaire');
    $controller = ControllerFactory::newController('commentaire');

    $controller->setInvalide($commentaire_id);
});
//Delete comment
$map->delete('delete.comment', '/delete/comment/{commentaire_id}', function ($request) {
    $commentaire_id = $request->getAttribute('commentaire_id');
    $controller = ControllerFactory::newController('commentaire');

    $controller->delete($commentaire_id);
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
