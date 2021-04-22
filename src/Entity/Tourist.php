<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TouristRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 * attributes={"pagination_client_enabled"=true,"pagination_client_items_per_page"=true,normalizationContext={"groups"={"tourist:read"}}},
 * )
 * @ORM\Entity(repositoryClass=TouristRepository::class)
 * @UniqueEntity("email")
 * @ApiFilter(BooleanFilter::class,properties={"isAdmin"})
 */
class Tourist implements UserInterface
{   #id_email_role_password_firstname_lastname_pseudo_registeredAt_profilePicture_nationality_gender

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
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
     * @Assert\Email( message = "The email '{{ value }}' is not a valid email.")
     * @Groups({"tourist:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"tourist:read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotNull(message="the password field should not be null")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tourist:read"})
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tourist:read"})
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Choice(choices=Tourist::Genders, message="Choose a valid gender.")
     * @Groups({"tourist:read"})
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     * @Groups({"tourist:read"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     * @Groups({"tourist:read"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"tourist:read"})
     */
    private $registeredAt;

    /**
     * @ORM\OneToOne(targetEntity=Photo::class, cascade={"persist", "remove"})
     * @Groups({"tourist:read"})
     */
    private $profilePicture;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"tourist:read"})
     */
    private $isAdmin;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getPseudo(): ?string
    {
        if(is_null($this->pseudo) || empty($this->pseudo)){
            try {
                return $this->getFirstName() . $this->getLastName() . random_int(111, 999);
            } catch (Exception $e) {
                return $this->getFirstName() . $this->getLastName();
            }
        }
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
}
