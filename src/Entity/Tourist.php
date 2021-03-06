<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TouristRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ApiResource(
 * attributes={"pagination_client_enabled"=true,
 *     "pagination_client_items_per_page"=true
 *    },
 * normalizationContext={"groups"={"tourist:read"},"skip_null_values"=false},
 * denormalizationContext={"groups"={"tourist:write"},"skip_null_values"=true},
 * collectionOperations={
 *     "get",
 *     "post"={
 *          "validation_groups"={"Default", "create"}
 *          }
 *     },
 * itemOperations={"delete","patch","get","put","patch"}
 * )
 * @ORM\Entity(repositoryClass=TouristRepository::class)
 * @UniqueEntity("email",message="this email is already used")
 * @ApiFilter(BooleanFilter::class,properties={"isAdmin"})
 * @ApiFilter (SearchFilter::class, properties={"id": "exact", "pseudo": "iexact","lastName": "istart" ,"firstName": "istart","$nationality":"iexact"})
 */
class Tourist implements UserInterface
{   #id_email_role_password_firstname_lastname_pseudo_registeredAt_profilePicture_nationality_gender


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tourist:read"})
     */
    private $id;

    const Genders = ['NOT SPECIFIED', 'MALE', 'FEMALE' ];
    const ROLES   = ['ROLE_USER','ROLE_ADMIN'];
    public function __construct()
    {

        $this->registeredAt=new DateTime();
        $this->setRoles(array("ROLE_USER"));
        $this->setGender(self::Genders[0]);
        $this->isAdmin=false;
    }
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Email( message = "The email '{{ value }}' is not a valid email.")
     * @Groups({"tourist:read","tourist:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"tourist:read","tourist:write"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Length(min=8,minMessage="Use at least 8 characters")
     * @Groups({"tourist:put","tourist:read","tourist:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tourist:read","tourist:put","tourist:write"})
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tourist:read","tourist:put","tourist:write"})
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Choice(choices=Tourist::Genders, message="Choose a valid gender.")
     * @Groups({"tourist:read","tourist:write"})
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Groups({"tourist:read","tourist:write","tourist:put"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Groups({"tourist:read","tourist:write","tourist:put"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"tourist:read","tourist:write"})
     */
    private $registeredAt;

    /**
     * @ORM\OneToOne(targetEntity=Photo::class, cascade={"persist", "remove"})
     * @Groups({"tourist:read","tourist:write"})
     */
    private $profilePicture;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"tourist:read"})
     */
    private $isAdmin;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Groups({"tourist:read","tourist:write","tourist:put"})
     */
    private $bio;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        #$roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        if(in_array('ROLE_ADMIN',$roles)){
            $this->setIsAdmin(true);
        }
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        //var_dump($password);
        #$hashedPassword= password_hash($password,PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 1]);
        $this->password = $password;
        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }
    //MALE FEMALE UNSPECIFIED//
    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getRegisteredAt(): ?DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getProfilePicture(): ?Photo
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?Photo $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }
}
