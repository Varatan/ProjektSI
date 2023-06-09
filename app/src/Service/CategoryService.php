<?php
/**
 * This is the license block.
 * It can contain licensing information, copyright notices, etc.
 */

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ReportRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Category Service.
 */
class CategoryService implements CategoryServiceInterface
{
    private CategoryRepository $categoryRepository;
    private ReportRepository $reportRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param CategoryRepository $categoryRepository Category repository
     * @param ReportRepository   $reportRepository   Report
     * @param PaginatorInterface $paginator          Paginator
     */
    public function __construct(CategoryRepository $categoryRepository, ReportRepository $reportRepository, PaginatorInterface $paginator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->reportRepository = $reportRepository;
        $this->paginator = $paginator;
    }

    /**
     * Save category.
     *
     * @param Category $category Category
     *
     * @return void Result
     */
    public function save(Category $category): void
    {
        if (null === $category->getId()) {
            $category->setCreatedAt(new \DateTimeImmutable());
        }
        $category->setUpdatedAt(new \DateTimeImmutable());

        $this->categoryRepository->save($category);
    }

    /**
     * Delete category.
     *
     * @param Category $category Category
     *
     * @return bool Bool
     */
    public function delete(Category $category): bool
    {
        if ($this->canBeDeleted($category)) {
            $this->categoryRepository->delete($category);

            return true;
        }

        return false;
    }

    /**
     * Can Category be deleted?*.
     *
     * @param Category $category Category entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Category $category): bool
    {
        try {
            $result = $this->reportRepository->countByCategory($category);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->categoryRepository->queryAll(),
            $page,
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Find by id.
     *
     * @param int $id Category id
     *
     * @return Category|null Category entity
     */
    public function findOneById(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
    }
}
