<?php

namespace App\Repository;

use App\Entity\TerrainCadastre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TerrainCadastre>
 *
 * @method TerrainCadastre|null find($id, $lockMode = null, $lockVersion = null)
 * @method TerrainCadastre|null findOneBy(array $criteria, array $orderBy = null)
 * @method TerrainCadastre[]    findAll()
 * @method TerrainCadastre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerrainCadastreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TerrainCadastre::class);
    }

    public function save(TerrainCadastre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TerrainCadastre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TerrainCadastre[] Returns an array of TerrainCadastre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TerrainCadastre
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
