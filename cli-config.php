<?php

$doctrine = new \Blog\Dependencies\Doctrine();

$em = $doctrine->getEm();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($em);