<?php
/**
 * Report service.
 */

namespace App\Service;

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
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->reportRepository->queryAll(),
            $page,
            ReportRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
