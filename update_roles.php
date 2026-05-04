<?php

require 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use App\Entity\User;

$container = require 'config/bootstrap.php';
$entityManager = $container->get('doctrine.orm.entity_manager');

// Find the user
$user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'ahmedhabouba@gmail.com']);
if ($user) {
    $user->setRoles(['ROLE_ADMIN']);
    $entityManager->flush();
    echo "Updated ahmedhabouba@gmail.com to ROLE_ADMIN\n";
}

// Similarly for others
$user2 = $entityManager->getRepository(User::class)->findOneBy(['email' => 'ahmedhabouba.com@gmail.com']);
if ($user2) {
    $user2->setRoles(['ROLE_GERANT']);
    $entityManager->flush();
    echo "Updated ahmedhabouba.com@gmail.com to ROLE_GERANT\n";
}

$user3 = $entityManager->getRepository(User::class)->findOneBy(['email' => 'kiko@gmail.com']);
if ($user3) {
    $user3->setRoles(['ROLE_OUVRIER']);
    $entityManager->flush();
    echo "Updated kiko@gmail.com to ROLE_OUVRIER\n";
}

$user4 = $entityManager->getRepository(User::class)->findOneBy(['email' => 'aa@mail.com']);
if ($user4) {
    $user4->setRoles(['ROLE_OWNER']);
    $entityManager->flush();
    echo "Updated aa@mail.com to ROLE_OWNER\n";
}

echo "Done\n";