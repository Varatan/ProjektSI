<?php

namespace App\Service;

use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * User service interface
 */
interface UserServiceInterface
{
    /**
     * Save entity.
     *
     * @param User $user
     * @return void
     */
    public function save(User $user): void;

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool;

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Find one by id
     *
     * @param int $id
     *
     * @return User|null
     */
    public function findOneById(int $id): ?User;

    /**
     * @param User $user
     * @return void
     */
    public function create(User $user): void;
}