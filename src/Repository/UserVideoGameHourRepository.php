<?php

namespace App\Repository;

use App\Entity\UserVideoGameHour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserVideoGameHour>
 *
 * @method UserVideoGameHour|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserVideoGameHour|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserVideoGameHour[]    findAll()
 * @method UserVideoGameHour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserVideoGameHourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserVideoGameHour::class);
    }

    public function save(UserVideoGameHour $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserVideoGameHour $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserVideoGameHour[] Returns an array of UserVideoGameHour objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserVideoGameHour
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
