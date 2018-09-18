<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {

        $error = $utils->getLastAuthenticationError();

        $lastUsername = $utils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {}

    /*public function register(UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $user->setUsername('rinatk');
        $user->setFirstName('Ринат');
        $user->setLastName('Кашапов');
        $plainPassword = '29338063';
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
    }*/
}
