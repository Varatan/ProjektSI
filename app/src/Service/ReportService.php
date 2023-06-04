<?php
/**
 * Report service.
 */

namespace App\Service;

use App\Entity\Report;
use App\Entity\User;
use App\Repository\ReportRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

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
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param ReportRepository     $reportRepository Report repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(ReportRepository $reportRepository, PaginatorInterface $paginator)
    {
        $this->reportRepository = $reportRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int  $page   Page number
     * @param User $author Author
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User $author): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->reportRepository->queryByAuthor($author),
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
}
