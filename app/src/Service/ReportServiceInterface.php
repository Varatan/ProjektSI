<?php
/**
 * This is the license block.
 * It can contain licensing information, copyright notices, etc.
 */
/**
 * Report service interface.
 */

namespace App\Service;

use App\Entity\Report;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface ReportServiceInterface.
 */
interface ReportServiceInterface
{
    /**
     * Get paginated report list.
     *
     * @param int  $page   Page
     * @param User $author Author
     *
     * @return PaginationInterface Pagination interface
     */
    public function getPaginatedList(int $page, User $author): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Report $report Task entity
     */
    public function save(Report $report): void;

    /**
     * Delete entity.
     *
     * @param Report $report Task entity
     */
    public function delete(Report $report): void;
}
