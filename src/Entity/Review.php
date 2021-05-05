<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     attributes={"pagination_client_enabled"=true,
 *     "pagination_client_items_per_page"=true
 *    },
 *     denormalizationContext={
 *     "groups"={"review:write"}
 *     }),
 *
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"review:write"})
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"review:write"})
     */
    private $content;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\GreaterThanOrEqual(value="0",message="The rating value should be greater than or equal to 0.")
     * @Assert\LessThanOrEqual(value="5",message="The rating value should be less than or equal to 5.")
     * @Groups({"review:write"})
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity=Tourist::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $publishedBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Poi::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poi;


    /**
     * Review constructor.
     */
    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getPublishedBy(): Tourist
    {
        return $this->publishedBy;
    }

    public function setPublishedBy(UserInterface $publishedBy): self
    {
        $this->publishedBy = $publishedBy;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPoi(): ?Poi
    {
        return $this->poi;
    }

    public function setPoi(?Poi $poi): self
    {
        $this->poi = $poi;

        return $this;
    }

}
