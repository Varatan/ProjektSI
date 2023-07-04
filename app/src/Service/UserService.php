<?php
/**
 * This is the license block.
 * It can contain licensing information, copyright notices, etc.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use App\Repository\ReportRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * User Service.
 */
class UserService implements UserServiceInterface
{
    private UserRepository $userRepository;

    private ReportRepository $reportRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param UserRepository     $userRepository   User repository
     * @param PaginatorInterface $paginator        Paginator
     * @param ReportRepository   $reportRepository Report repository
     */
    public function __construct(UserRepository $userRepository, PaginatorInterface $paginator, ReportRepository $reportRepository)
    {
        $this->userRepository = $userRepository;
        $this->paginator = $paginator;
        $this->reportRepository = $reportRepository;
    }

    /**
     * Save user.
     *
     * @param User $user User entity
     *
     * @return void Result
     */
    public function save(User $user): void
    {
        $this->userRepository->save($user);
    }

    /**
     * Create user.
     *
     * @param User $user User entity
     *
     * @return void Result
     */
    public function create(User $user): void
    {
        $this->userRepository->create($user);
    }

    /**
     * Delete user.
     *
     * @param User $user User entity
     *
     * @return bool Bool
     */
    public function delete(User $user): bool
    {
        /*        $this->userRepository->remove($user);
                return true;*/
        if ($this->canBeDeleted($user)) {
            $this->userRepository->remove($user);

            return true;
        }

        return false;
    }

    /**
     * Can user be deleted?
     *
     * @param User $user User
     *
     * @return bool Bool
     */
    public function canBeDeleted(User $user): bool
    {
        try {
            $result = $this->reportRepository->countByUser($user);

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
            $this->userRepository->queryAll(),
            $page,
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Find by id.
     *
     * @param int $id User id
     *
     * @return User|null User entity
     */
    public function findOneById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }
}
