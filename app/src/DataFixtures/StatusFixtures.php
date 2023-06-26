<?php
/**
 * This is the license block.
 * It can contain licensing information, copyright notices, etc.
 */
/**
 * Status fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Status;

/**
 * Class Status Fixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class StatusFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(4, 'statuses', function (int $i) {
            $status = new Status();
            $status->setTitle($this->faker->unique()->word);

            return $status;
        });

        $this->manager->flush();
    }
}
