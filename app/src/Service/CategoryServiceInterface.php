<?php
/**
 * This is the license block.
 * It can contain licensing information, copyright notices, etc.
 */
namespace App\Service;

use App\Entity\Category;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Category service interface.
 */
interface CategoryServiceInterface
{

    /**
     * Save category
     *
     * @param Category $category
     *
     * @return void
     */
    public function save(Category $category): void;


    /**
     * Delete category
     *
     * @param Category $category
     *
     * @return bool
     */
    public function delete(Category $category): bool;

    /**
    Can Category be deleted?*
    @param Category $category Category entity*

    *    @return bool Result*/
    public function canBeDeleted(Category $category): bool;

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Find category by ID
     *
     * @param int $id
     *
     * @return Category|null
     */
    public function findOneById(int $id): ?Category;
}
