<?php

namespace App\Repository;

use App\Component\AsteriskMonitor;
use App\Entity\QueueResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QueueResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method QueueResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method QueueResult[]    findAll()
 * @method QueueResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QueueResultRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(RegistryInterface $registry)
    {
        $this->manager = $registry;
        parent::__construct($registry, QueueResult::class);
    }

    public function getDataFromAsterisk() {

        $model = $this->createQueryBuilder('q')
            ->orderBy('q.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();

        $data = false;
        if ($model) {
            $dtUpdated = $model->getUpdatedAt();
            $dtNow = new \DateTime();
            $tmsUpdated = $dtUpdated->getTimestamp();
            $tmsNow = $dtNow->getTimestamp();


            if (($tmsNow - $tmsUpdated) > 10) {
                $monitor = new AsteriskMonitor($this->manager);
                $data = $monitor->getMonitorData();
                $model->setData($data);
                $this->manager->getManager()->persist($model);
            }

        } else {
            $model = new QueueResult();
            $monitor = new AsteriskMonitor($this->manager);
            $data = $monitor->getMonitorData();
        }
        if ($data) {
            $model->setData($data);
            $this->manager->getManager()->persist($model);
            $this->getEntityManager()->persist($model);
            return true;

        }
        return false;
    }

//    /**
//     * @return QueueResult[] Returns an array of QueueResult objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QueueResult
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
