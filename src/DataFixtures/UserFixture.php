<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword(
            $this->encoder->encodePassword($user, '0000')
        );

        $user->setFirstName('Ринат');
        $user->setLastName('Кашапов');

        $user->setEmail('rinatkzz@yandex');

        $dtNow = new \DateTime();

        $user->setCreatedAt($dtNow);

        $user->setUpdatedAt($dtNow);

        $manager->persist($user);
        $manager->flush();
    }
}
