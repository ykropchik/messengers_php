<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

     /**
      * @return Message[] Returns an array of Message objects
      */
    public function findByTwoUsers($first, $second)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->where($qb->expr()->orX(
            $qb->expr()->andX($qb->expr()->eq('m.author', ':first'), $qb->expr()->eq('m.addresse', ':second')),
            $qb->expr()->andX($qb->expr()->eq('m.author', ':second'), $qb->expr()->eq('m.addresse', ':first'))
        ))
            ->setParameter('first', $first)
            ->setParameter('second', $second);
//            ->orderBy('m.date_create', 'DESC');

        return $qb->getQuery()->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
