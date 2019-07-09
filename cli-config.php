

<?php
require_once 'vendor/autoload.php';

use Blog\Controller;

$dl = new Controller();

$entityManager = $dl->entityManager;

use Doctrine\ORM\Tools\Console\ConsoleRunner;

return ConsoleRunner::createHelperSet($entityManager);
