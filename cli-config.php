

<?php
# cli-config.php
require_once 'vendor/autoload.php';

use Blog\DoctrineLoader;

$dl = new DoctrineLoader();

$entityManager = $dl->entityManager;

use Doctrine\ORM\Tools\Console\ConsoleRunner;

return ConsoleRunner::createHelperSet($entityManager);
