<?php
/**
 * Blog Index
 *
 */
require __DIR__ . '/vendor/autoload.php';
use Blog\Service\ControllerFactory;

$session = new \Blog\Service\UserSession();
$session->start();

if ($session->isStored()) {
    $user = $session->get();
} else {
    $user = new \Blog\Entity\Utilisateur();
}



// create a server request object
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_GET,
    $_POST
);

// create the router container and get the routing map
$routerContainer = new Aura\Router\RouterContainer();
$map = $routerContainer->getMap();

$map->get(
    'blog.home',
    '/',
    function () {
        $controller = ControllerFactory::newController('home');
        $controller->homePage();
    }
);
//list article
$map->get(
    'blog.articles',
    '/articles',
    function () {
        $controller = ControllerFactory::newController('article');
        $controller->getListFront();
    }
);
//View One route
$map->get(
    'blog.viewOne',
    '/read/{slug}',
    function ($request) {
        $slug = (string) $request->getAttribute('slug');
        $controller = ControllerFactory::newController('article');

        $controller->getOneBySlug($slug);
    }
);
//Contact get Route
$map->get(
    'blog.contact',
    '/contact',
    function () {
        $controller = ControllerFactory::newController('contact');

        $controller->contactPage();
    }
);
//Send demand from the article controller
$map->post(
    'blog.contact.send',
    '/contact/send',
    function ($request) {
        $controller = ControllerFactory::newController('contact');

        $data = $request->getParsedBody();

        $controller->contactSend($data);
    }
);
//Admin Homepag
$map->get(
    'admin.home',
    '/admin',
    function () use ($user) {
        if ($user->isAdmin()) {
            $controller = ControllerFactory::newController('home');
            $controller->homeAdmin();
        } else {
            throw new Exception('Vous n\'avez pas accès a cette page ');
        }
    }
);
//List article for admin
$map->get(
    'article.list',
    '/list/article',
    function () use ($user) {
        if ($user->isAdmin()) {
            $controller = ControllerFactory::newController('article');
            $controller->getListAdmin();
        } else {
            throw new Exception('Vous n\'avez pas accès a cette page ');
        }
    }
);
//Route for the creation
$map->get(
    'article.create',
    '/create/article',
    function () use ($user) {
        if ($user->isAdmin() && $user !== null) {
            $controller = ControllerFactory::newController('article');
            $controller->create();
        }
    }
);
//Save Article Route
$map->post(
    'article.save',
    '/save/article',
    function ($request) use ($user) {
        if ($user->isAdmin()) {
            $data = $request->getParsedBody();
            $controller = ControllerFactory::newController('article');
            $controller->save($data, $user);
        } else {
            throw new Exception('Vous n\'avez pas accès a cette page ');
        }
    }
);
//Render the article
$map->get(
    'article.update',
    '/update/article/{article_id}',
    function ($request) use ($user) {
        if ($user->isAdmin()) {
            $article_id = $request->getAttribute('article_id');
            $controller = ControllerFactory::newController('article');
            $controller->update($article_id);
        } else {
            throw new Exception('Vous n\'ête pas autorisé à effectué cette action');
        }
    }
);
//Save the updated Article
$map->post(
    'article.update.save',
    '/update/article/{article_id}',
    function ($request) use ($user) {
        if ($user->isAdmin()) {
            $article_id = $request->getAttribute('article_id');
            $data = $request->getParsedBody();
            $controller = ControllerFactory::newController('article');

            $controller->saveUpdate($data, $article_id);
        } else {
            throw new Exception('Vous n\'ête pas autorisé à effectué cette action');
        }
    }
);
//Delete article
$map->get(
    'article.delete',
    '/delete/article/{article_id}/{token}',
    function ($request) use ($user) {
        if ($user->isAdmin()) {
            $token = $request->getAttribute('token');
            $article_id = $request->getAttribute('article_id');
            $controller = ControllerFactory::newController('article');

            $controller->delete($article_id, $token);
        } else {
            throw new Exception('Vous n\'ête pas autorisé à effectué cette action');
        }
    }
);
//render the register form
$map->get(
    'user.register',
    '/register',
    function () {
        $controller = ControllerFactory::newController('utilisateur');

        $controller->register();
    }
);
//Save new user in the database
$map->post(
    'user.register.save',
    '/register',
    function ($request) {
        $data = $request->getParsedBody();
        $controller = ControllerFactory::newController('utilisateur');
        $controller->createUser($data);
    }
);
//Login page
$map->get(
    'user.login',
    '/login',
    function () {
        $controller = ControllerFactory::newController('utilisateur');

        $controller->loginPage();
    }
);
//Login the user
$map->post(
    'user.login.action',
    '/login',
    function ($request) use ($session) {
        $data = $request->getParsedBody();
        $controller = ControllerFactory::newController('utilisateur');

        $controller->login($data, $session);
    }
);
//Logout
$map->get(
    'user.logout',
    '/logout',
    function () use ($session) {
        $controller = ControllerFactory::newController('utilisateur');

        $controller->logout($session);
    }
);
//Get comments
$map->get(
    'admin.comments',
    '/list/comments',
    function () use ($user) {
        if ($user->isAdmin()) {
            $controller = ControllerFactory::newController('commentaire');

            $controller->getAll();
        } else {
            throw new Exception('Vous n\'avez pas accès a cette page ');
        }
    }
);
//Save comment
$map->post(
    'save.comment',
    '/save/comment/{article_id}',
    function ($request) use ($user) {
        $articleId = $request->getAttribute('article_id');
        $auteur = $user;
        $datas = $request->getParsedBody();
        $controller = ControllerFactory::newController('commentaire');

        $controller->save($articleId, $auteur, $datas);
    }
);
//Valide comment
$map->get(
    'valide.comment',
    '/valide/{commentaire_id}',
    function ($request) use ($user) {
        if ($user->isAdmin()) {
            $commentaire_id = $request->getAttribute('commentaire_id');
            $controller = ControllerFactory::newController('commentaire');

            $controller->setValide($commentaire_id);
        } else {
            throw new Exception('Vous n\'ête pas autorisé à effectuer cette action');
        }
    }
);
//Invalide comment
$map->get(
    'invalide.comment',
    '/invalide/{commentaire_id}',
    function ($request) use ($user) {
        if ($user->isAdmin()) {
            $commentaire_id = $request->getAttribute('commentaire_id');
            $controller = ControllerFactory::newController('commentaire');

            $controller->setInvalide($commentaire_id);
        } else {
            throw new Exception('Vous n\'ête pas autorisé à effectuer cette action');
        }
    }
);
//Delete comment
$map->get(
    'delete.comment',
    '/delete/comment/{commentaire_id}/{token}',
    function ($request) use ($user) {
        if ($user->isAdmin()) {
            $commentaire_id = $request->getAttribute('commentaire_id');
            $controller = ControllerFactory::newController('commentaire');

            $token = $request->getAttribute('token');

            $controller->delete($commentaire_id, $token);
        }
    }
);
//CV
$map->get(
    'cv',
    '/cv',
    function () {
        header("Content-type:application/pdf");
        readfile("Assets/img/cvThomasLarousse2.pdf");
    }
);




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
