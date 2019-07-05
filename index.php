<?php
require __DIR__ . '/vendor/autoload.php';
use Blog\Service\ControllerFactory;

session_start();

$user = unserialize($_SESSION['user']);
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
$map->get('blog.home', '/', function() {
    $controller = ControllerFactory::newController('article');
    $controller->getAll();
});
//View One route
$map->get('blog.viewOne', '/read/{slug}', function($request) {
    $slug = (string) $request->getAttribute('slug');
    $controller = ControllerFactory::newController('article');

    $controller->getOneBySlug($slug);
});
//Contact get Route
$map->get('blog.contact', '/contact', function() {
    $controller = ControllerFactory::newController('contact');

    $controller->contactPage();
});
//Send demand from the article controller
$map->post('blog.contact.send', '/contact/send', function($request) {
    $controller = ControllerFactory::newController('contact');

    $data = $request->getParsedBody();

    $controller->contactSend($data);
});
//List article for admin
$map->get('article.list', '/list/article', function() use ($user) {
    if ($user->isAdmin()) {
        $controller = ControllerFactory::newController('article');
        $controller->getList();
    } else {
        throw new Exception('Vous n\'avez pas accès a cette page ');
    }
});
//Route for the creation
$map->get('article.create', '/create/article', function() use ($user) {
    if ($user->isAdmin()) {
        $controller = ControllerFactory::newController('article');
        $controller->create();
    } else {
        throw new Exception('Vous n\'avez pas accès a cette page ');
    }
});
//Save Article Route
$map->post('article.save', '/save/article', function($request) use ($user) {
    if ($user->isAdmin()) {
        $data = $request->getParsedBody();

        $controller = ControllerFactory::newController('article');
        $controller->save($data);
    } else {
        throw new Exception('Vous n\'avez pas accès a cette page ');
    }
});
//Render the article
$map->get('article.update', '/update/article/{article_id}', function($request) use ($user) {
    if ($user->isAdmin()) {
        $article_id = $request->getAttribute('article_id');
        $controller = ControllerFactory::newController('article');
        $controller->update($article_id);
    } else {
        throw new Exception('Vous n\'ête pas autorisé à effectué cette action');
    }
});
//Save the updated Article
$map->post('article.update.save', '/update/article/{article_id}', function($request) use ($user) {
    if ($user->isAdmin()) {
        $article_id = $request->getAttribute('article_id');
        $data = $request->getParsedBody();
        $controller = ControllerFactory::newController('article');

        $controller->saveUpdate($data, $article_id);
    } else {
        throw new Exception('Vous n\'ête pas autorisé à effectué cette action');
    }
});
//Delete article
$map->get('article.delete', '/delete/article/{article_id}', function($request) use ($user) {
    if ($user->isAdmin()) {
        $article_id = $request->getAttribute('article_id');
        $controller = ControllerFactory::newController('article');

        $controller->delete($article_id);
    } else {
        throw new Exception('Vous n\'ête pas autorisé à effectué cette action');
    }
});
//render the register form
$map->get('user.register', '/register', function() {
    $controller = ControllerFactory::newController('utilisateur');

    $controller->register();
});
//Save new user in the database
$map->post('user.register.save', '/register', function($request) {
    $data = $request->getParsedBody();

    $controller = ControllerFactory::newController('utilisateur');
    $controller->createUser($data);
});
//Login page
$map->get('user.login', '/login', function() {
    $controller = ControllerFactory::newController('utilisateur');

    $controller->loginPage();
});
//Login the user
$map->post('user.login.action', '/login', function($request) {
    $data = $request->getParsedBody();
    $controller = ControllerFactory::newController('utilisateur');

    $controller->login($data);
});
//Logout
$map->get('user.logout', '/logout', function() {
    $controller = ControllerFactory::newController('utilisateur');

    $controller->logout();
});
//Get comments
$map->get('get.comments', '/admin/comments', function() use ($user) {
    if ($user->isAdmin()) {
        $controller = ControllerFactory::newController('commentaire');

        $controller->getAll();
    } else {
        throw new Exception('Vous n\'avez pas accès a cette page ');
    }
});
//Save comment
$map->post('save.comment', '/save/comment/{article_id}', function($request) {
    $articleId = $request->getAttribute('article_id');
    $auteur = unserialize($_SESSION['user']);
    $contenu = $request->getParsedBody();
    $controller = ControllerFactory::newController('commentaire');

    $controller->save($articleId, $auteur, $contenu);
});
//Valide comment
$map->get('valide.comment', '/valide/{commentaire_id}', function($request) use ($user) {
    if ($user->isAdmin()) {
        $commentaire_id = $request->getAttribute('commentaire_id');
        $controller = ControllerFactory::newController('commentaire');

        $controller->setValide($commentaire_id);
    } else {
        throw new Exception('Vous n\'ête pas autorisé à effectuer cette action');
    }
});
//Invalide comment
$map->get('invalide.comment', '/invalide/{commentaire_id}', function($request) use ($user) {
    if ($user->isAdmin()) {
        $commentaire_id = $request->getAttribute('commentaire_id');
        $controller = ControllerFactory::newController('commentaire');

        $controller->setInvalide($commentaire_id);
    } else {
        throw new Exception('Vous n\'ête pas autorisé à effectuer cette action');
    }
});
//Delete comment
$map->get('delete.comment', '/delete/comment/{commentaire_id}', function($request) use ($user) {
    if ($user->isAdmin()) {
        $commentaire_id = $request->getAttribute('commentaire_id');
        $controller = ControllerFactory::newController('commentaire');

        $controller->delete($commentaire_id);
    } else {
        throw new Exception('Vous n\'ête pas autorisé à effectuer cette action');
    }
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
