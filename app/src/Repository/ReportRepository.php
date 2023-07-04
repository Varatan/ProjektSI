<?php
/**
 * This is the license block.
 * It can contain licensing information, copyright notices, etc.
 */

/**
 * Report repository.
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Report;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Class ReportRepository.
 *
 * @method Report|null find($id, $lockMode = null, $lockVersion = null)
 * @method Report|null findOneBy(array $criteria, array $orderBy = null)
 * @method Report[]    findAll()
 * @method Report[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<Report>
 *
 * @psalm-suppress LessSpecificImplementedReturnType
 */
class ReportRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in configuration files.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Report::class);
    }

    /**
     * Query all records.
     *
     * @param array $filters Filter array
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(array $filters): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial report.{id, createdAt, updatedAt, title, content}',
                'partial category.{id, title}',
                'partial status.{id, title}'
            )
            ->join('report.category', 'category')
            ->join('report.status', 'status')
            ->orderBy('report.createdAt', 'DESC');

        return $this->applyFiltersToList($queryBuilder, $filters);
    }

    /**
     * Query reports by author.
     *
     * @param User                  $user    User entity
     * @param array<string, object> $filters Filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryByAuthor(User $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);

        $queryBuilder->andWhere('report.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    /**
     * Count reports by category.
     *
     * @param Category $category Report category
     *
     * @return int Result
     *
     * @throws NoResultException        No result exception
     * @throws NonUniqueResultException Non unique result exception
     */
    public function countByCategory(Category $category): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('report.id'))
            ->where('report.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Count reports by user.
     *
     * @param User $user User entity
     *
     * @return int Result
     *
     * @throws NoResultException        No Result Exception
     * @throws NonUniqueResultException Non unique Result Excpetion
     */
    public function countByUser(User $user): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('report.id'))
            ->where('report.author = :user')
            ->setParameter(':user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Save entity.
     *
     * @param Report $report Report entity
     *
     * @return void Result
     */
    public function save(Report $report): void
    {
        $this->_em->persist($report);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Report $report Task entity
     */
    public function delete(Report $report): void
    {
        $this->_em->remove($report);
        $this->_em->flush();
    }

    /**
     * Apply filters to paginated list.
     *
     * @param QueryBuilder          $queryBuilder Query builder
     * @param array<string, object> $filters      Filters array
     *
     * @return QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['category']) && $filters['category'] instanceof Category) {
            $queryBuilder->andWhere('category = :category')
                ->setParameter('category', $filters['category']);
        }

        return $queryBuilder;
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('report');
    }
}
