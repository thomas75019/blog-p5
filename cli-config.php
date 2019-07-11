

<?php
require_once 'vendor/autoload.php';

$doctrine = new \Blog\Dependencies\Doctrine();

$entityManager = $doctrine->entityManager;

use Doctrine\ORM\Tools\Console\ConsoleRunner;

return ConsoleRunner::createHelperSet($entityManager);
