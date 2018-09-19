<?php

namespace App\Repository;

use App\Component\Helper;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{

    protected $encoder;
    protected $required_fields = ['first_name', 'last_name', 'email', 'password'];

    public function __construct(RegistryInterface $registry, UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        parent::__construct($registry, User::class);
    }

    public function findByUsername($username) {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function validateNew(array $data) {
        $is_ok = true;

        foreach ($this->required_fields as $field) {
            if (empty($data[$field])) {
                $is_ok = false;
            }
        }
        $email = $data['email'] ?? '';
        if ($email) {
            $existedUser = $this->findBy(['email' => $email]);
            if ($existedUser) {
                $is_ok = false;
            }
        }
        return $is_ok;
    }

    public function create($data) {

        if (!$this->validateNew($data)) {
            return false;
        }

        $manager = $this->getEntityManager();

        $user = new User();

        $username = $this->generateUsernameFromEmail($data['email']);

        $user->setUsername($username);
        $user->setPassword(

            $this->encoder->encodePassword($user, $data['password'])
        );

        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setEmail($data['email']);

        $dtNow = new \DateTime();

        $user->setCreatedAt($dtNow);
        $user->setUpdatedAt($dtNow);

        $role = $this->getEntityManager()->getRepository(Role::class)->find($data['role']);
        $user->addRole($role);

        $manager->persist($user);
        $manager->flush();

        return $user->getUsername();
    }

    protected function generateUsername(string $first_name, string $last_name, string $email) {
        $username = '';
        if (!empty($email)) {
            $username = $this->generateUsernameFromEmail($email);

            $result = $this->findByUsername($username);

            if ($result) {
                //$username .= bin2hex(random_bytes(3));
                return false;
            }
        }
        if (empty($username)) {
            $username = Helper::convertRusToEn($first_name) . '.' . Helper::convertRusToEn($last_name);
        }
        return $username;
    }
    protected function generateUsernameFromEmail($email) {
        $matches = null;
        preg_match('/(.+)@(.+)\\.(.+)/', $email, $matches);
        if (count($matches) > 1) {
            return $matches[1];
        }
        return false;
    }
}
