<?php
/**
 * This is the license block.
 * It can contain licensing information, copyright notices, etc.
 */

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Status.
 */
#[ORM\Entity(repositoryClass: StatusRepository::class)]
#[ORM\Table(name: 'statuses')]
#[ORM\UniqueConstraint(name: 'uq_categories_title', columns: ['title'])]
#[UniqueEntity(fields: ['title'])]
class Status
{
    /**
     * Id.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Title.
     */
    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $title = null;

    /**
     * Getter for id.
     *
     * @return int|null This id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for title.
     *
     * @return string|null This title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for title.
     *
     * @param string $title Title
     *
     * @return $this Status
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
