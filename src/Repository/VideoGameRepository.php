<?php

namespace App\Repository;

use App\Dto\VideoGamePaginatedListDto;
use App\Entity\VideoGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VideoGame>
 *
 * @method VideoGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoGame[]    findAll()
 * @method VideoGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoGame::class);
    }

    public function save(VideoGame $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VideoGame $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VideoGame[] Returns an array of VideoGame objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VideoGame
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function getListPaginated($page, $limit): VideoGamePaginatedListDto
    {
        $offset = ($page - 1) * $limit;
        $query = $this->createQueryBuilder('v')
            ->orderBy('v.id', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $paginator = new Paginator($query->getQuery());

        return new VideoGamePaginatedListDto(
            $page,
            $limit,
            (int) ceil($paginator->count() / $limit),
            $paginator->count(),
            $paginator->getQuery()->getResult()
        );
    }
}
