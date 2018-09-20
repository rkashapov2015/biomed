<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class RoleFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $role_names = [
            ['ROLE_USER', 'Стандартная учетная запись пользователя'],
            ['ROLE_ADMIN', 'Стандартная учетная запись администратора']
        ];

        foreach ($role_names as $role_name) {
            $dt = new \DateTime();

            $role = new Role();
            $role->setName($role_name[0]);
            $role->setDescription($role_name[1]);
            $role->setCreatedAt($dt);
            $role->setUpdatedAt($dt);

            $manager->persist($role);
            $manager->flush();
        }


        $user = $manager->getRepository(User::class)->find(1);
        if ($user) {
            $roles = $manager->getRepository(Role::class)->findAll();

            foreach ($roles as $role) {
                $user->addRole($role);
            }

            $manager->persist($user);
            $manager->flush();
        }
    }
}
