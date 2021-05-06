<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\PoiRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\{SearchFilter};
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     attributes={"pagination_client_enabled"=true,
 *     "pagination_client_items_per_page"=true
 *    },
 *     subresourceOperations={
 *          "api_pois_photos_get_subresource"={
 *              "method"="GET",
 *          },
 *           "childrens_get_subresource"={
 *               "path"="/pois/{id}/children.{_format}"
 *     }
 *      },
 *     denormalizationContext={
 *          "groups"={
 *                   "poi:write"
 *                 }
 *     },
 *     itemOperations={
 *          "get"={"normalization_context"={ "groups"={"poi_item:read"} }}
 *     },normalizationContext={"groups"={"poi_item:read"}}
 *     )
 * @ApiFilter(SearchFilter::class, properties={
 *                              "typeOfAttraction": "exact",
 *                              "typeOfAttraction.parentType": "exact",
 *                              "address.city": "exact"
 *            })
 * @ORM\Entity(repositoryClass=PoiRepository::class)
 */
class Poi
{
#http://localhost:8000/api/pois.json?typeOfAttraction.parentType=4
#http://localhost:8000/api/pois.json?typeOfAttraction=7

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"poi:write","poi_item:read"})
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"poi_item:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"poi_item:read"})
     */
    private $updatedAt;


    /**
     * @ORM\OneToMany(targetEntity=Description::class, mappedBy="poi", orphanRemoval=true,cascade={"persist"})
     * @Groups({"poi:write","poi_item:read"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Audio::class, mappedBy="poi", orphanRemoval=true,cascade={"persist"})
     * @Groups({"poi:write","poi_item:read"})
     */
    private $audio;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="poi", orphanRemoval=true,cascade={"persist"})
     * @ApiSubresource(maxDepth=1)
     * @Groups({"poi:write","poi_item:read"})
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=Poi::class, inversedBy="children")
     * @Groups({"poi:write","poi_item:read"})
     * @ApiProperty(readableLink=false, writableLink=false)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Poi::class, mappedBy="parent",orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfAttraction::class, inversedBy="pois")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"poi:write","poi_item:read"})
     */
    private $typeOfAttraction;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"poi:write","poi_item:read"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="poi", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $reviews;



    public function __construct()
    {
        $this->description = new ArrayCollection();
        $this->audio = new ArrayCollection();
        $this->photo = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->createdAt=new DateTime();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    /**
     * @return Collection|Description[]
     */
    public function getDescription(): Collection
    {
        return $this->description;
    }

    public function addDescription(Description $description): self
    {
        if (!$this->description->contains($description)) {
            $this->description[] = $description;
            $description->setPoi($this);
        }

        return $this;
    }

    public function removeDescription(Description $description): self
    {
        if ($this->description->removeElement($description)) {
            // set the owning side to null (unless already changed)
            if ($description->getPoi() === $this) {
                $description->setPoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Audio[]
     */
    public function getAudio(): Collection
    {
        return $this->audio;
    }

    public function addAudio(Audio $audio): self
    {
        if (!$this->audio->contains($audio)) {
            $this->audio[] = $audio;
            $audio->setPoi($this);
        }

        return $this;
    }

    public function removeAudio(Audio $audio): self
    {
        if ($this->audio->removeElement($audio)) {
            // set the owning side to null (unless already changed)
            if ($audio->getPoi() === $this) {
                $audio->setPoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhoto(): Collection
    {
        return $this->photo;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photo->contains($photo)) {
            $this->photo[] = $photo;
            $photo->setPoi($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photo->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getPoi() === $this) {
                $photo->setPoi(null);
            }
        }

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getTypeOfAttraction(): ?TypeOfAttraction
    {
        return $this->typeOfAttraction;
    }

    public function setTypeOfAttraction(?TypeOfAttraction $typeOfAttraction): self
    {
        $this->typeOfAttraction = $typeOfAttraction;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setPoi($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getPoi() === $this) {
                $review->setPoi(null);
            }
        }

        return $this;
    }

    public function getTotalReviews(){
        return $this->reviews->count();
    }
    public function getRating() :int
    {
        $reviews=$this->reviews;
        $som=0;
       foreach ($reviews as $review){
           $som+=$review->getRate();
       }
        return $som/$reviews->count();

    }
}
