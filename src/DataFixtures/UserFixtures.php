<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $haser;
    public function __construct(UserPasswordHasherInterface $haser)
    {
        $this->haser=$haser;
    }

    public function load(ObjectManager $manager): void
    {
        $superAdmin = $this->createSuperAdmin();

        $manager->persist($superAdmin);

        $manager->flush();
    }

    private function createSuperAdmin() : User
    {
        $user = new User();

        $passwordHased = $this->haser->hashPassword($user, "AzertyU1234@");

        $user->setFirstName('Iulian');
        $user->setLastName('Rotaru');
        $user->setEmail('rotarui@bvoyage.com');
        $user->setRoles(["ROLE_SUPER_ADMIN", "ROLE_ADMIN", "ROLE_USER"]);
        $user->setIsVerified(true);
        $user->setPassword($passwordHased);
        $user->setVerifiedAt(new DateTimeImmutable('now'));

        return $user;
    }
}
