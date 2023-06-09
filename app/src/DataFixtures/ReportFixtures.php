<?php
/**
 * Report fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Enum\ReportStatus;
use App\Entity\Status;
use App\Entity\Tag;
use App\Entity\Report;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class ReportFixtures.
 */
class ReportFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(100, 'reports', function (int $i) {
            $report = new Report();
            $report->setTitle($this->faker->sentence);
            $report->setContent($this->faker->sentence);
            $report->setCreatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $report->setUpdatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );

            /** @var Status $status */
            $status = $this->getRandomReference('statuses');
            $report->setStatus($status);


            /** @var Category $category */
            $category = $this->getRandomReference('categories');
            $report->setCategory($category);

            /** @var User $author */
            $author = $this->getRandomReference('users');
            $report->setAuthor($author);

            return $report;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: CategoryFixtures::class, 1:UserFixtures::class}
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class, UserFixtures::class];
    }
}
