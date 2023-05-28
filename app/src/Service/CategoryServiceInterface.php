<?php

namespace App\Service;

use App\Entity\Category;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Category service interface
 */
interface CategoryServiceInterface
{
    /**
     * @param Category $category
     * @return void
     */
    public function save(Category $category): void;

    /**

    Can Category be deleted?*
    @param Category $category Category entity*
    @return bool Result*/
    public function canBeDeleted(Category $category): bool;

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;
}