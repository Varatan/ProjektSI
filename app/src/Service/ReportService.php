<?php
/**
 * This is the license block.
 * It can contain licensing information, copyright notices, etc.
 */

/**
 * Report service.
 */

namespace App\Service;

use App\Entity\Report;
use App\Entity\User;
use App\Repository\ReportRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class ReportService.
 */
class ReportService implements ReportServiceInterface
{
    /**
     * Report repository.
     */
    private ReportRepository $reportRepository;

    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Security.
     */
    private Security $security;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param ReportRepository         $reportRepository Report repository
     * @param PaginatorInterface       $paginator        Paginator
     * @param Security                 $security         Security
     * @param CategoryServiceInterface $categoryService  Category service
     */
    public function __construct(ReportRepository $reportRepository, PaginatorInterface $paginator, Security $security, CategoryServiceInterface $categoryService)
    {
        $this->reportRepository = $reportRepository;
        $this->paginator = $paginator;
        $this->security = $security;
        $this->categoryService = $categoryService;
    }

    /**
     * Get paginated report list.
     *
     * @param int   $page    Page
     * @param User  $author  User entity
     * @param array $filters Filter array
     *
     * @return PaginationInterface Pagination interface
     */
    public function getPaginatedList(int $page, User $author, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->paginator->paginate(
                $this->reportRepository->queryAll($filters),
                $page,
                ReportRepository::PAGINATOR_ITEMS_PER_PAGE
            );
        }

        return $this->paginator->paginate(
            $this->reportRepository->queryByAuthor($author, $filters),
            $page,
            ReportRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Report $report Task entity
     */
    public function save(Report $report): void
    {
        $this->reportRepository->save($report);
    }

    /**
     * Delete entity.
     *
     * @param Report $report Task entity
     */
    public function delete(Report $report): void
    {
        $this->reportRepository->delete($report);
    }

    /**
     * Prepare filters for the tasks list.
     *
     * @param array $filters Filter array
     *
     * @return array Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryService->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        return $resultFilters;
    }
}
