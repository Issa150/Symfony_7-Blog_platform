<?php

// namespace App\Entity;

// use App\Repository\UsersRepository;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;
// use Doctrine\ORM\Mapping as ORM;
// use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
// use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
// use Symfony\Component\Security\Core\User\UserInterface;
// use Symfony\Component\Validator\Constraints as Assert;

// #[ORM\Entity(repositoryClass: UsersRepository::class)]
// #[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
// #[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
// class Users implements UserInterface, PasswordAuthenticatedUserInterface
// {
//     #[ORM\Id]
//     #[ORM\GeneratedValue]
//     #[ORM\Column]
//     private ?int $id = null;

//     #[ORM\Column(length: 180)]
//     #[Assert\NotBlank]
//     #[Assert\Length(min: 6, max: 20)]
//     private ?string $username = null;

//     /**
//      * @var list<string> The user roles
//      */
//     #[ORM\Column]
//     private array $roles = [];

//     /**
//      * @var string The hashed password
//      */
//     #[ORM\Column]
//     #[Assert\Length(min: 6)]
//     #[Assert\Regex(pattern: '/\d/')]
//     #[Assert\Regex(pattern: '/[A-Z]/')]
//     #[Assert\Regex(pattern: '/[a-z]/')]
//     #[Assert\Regex(pattern: '/[!@#$%^&*(),.?":{}|<>]/')]
//     private ?string $password = null;

//     #[ORM\Column(length: 50, nullable: true)]
//     #[Assert\NotBlank]
//     #[Assert\Length(min: 3, max: 50)]
//     private ?string $firstname = null;

//     #[ORM\Column(length: 100, nullable: true)]
//     #[Assert\NotBlank]
//     #[Assert\Length(min: 3, max: 50)]
//     private ?string $lastname = null;

//     #[ORM\Column(length: 255, nullable: true)]
//     private ?string $imageProfile = null;

//     #[ORM\Column(length: 255, nullable: true)]
//     private ?string $imageCover = null;

//     #[ORM\Column(length: 100, nullable: true)]
//     private ?string $city = null;

//     #[ORM\Column(length: 100, nullable: true)]
//     private ?string $country = null;

//     #[ORM\Column(length: 20, nullable: true)]
//     private ?string $gender = null;

//     /**
//      * @var Collection<int, Posts>
//      */
//     #[ORM\OneToMany(targetEntity: Posts::class, mappedBy: 'userId', orphanRemoval: true)]
//     private Collection $posts;

//     /**
//      * @var Collection<int, ContentType>
//      */
//     #[ORM\OneToMany(targetEntity: ContentType::class, mappedBy: 'userId')]
//     private Collection $contentTypes;

//     /**
//      * @var Collection<int, Categories>
//      */
//     #[ORM\OneToMany(targetEntity: Categories::class, mappedBy: 'userId', orphanRemoval: true)]
//     private Collection $categories;

//     #[ORM\Column(length: 255, nullable: true)]
//     private ?string $email = null;

//     public function __construct()
//     {
//         $this->posts = new ArrayCollection();
//         $this->contentTypes = new ArrayCollection();
//         $this->categories = new ArrayCollection();
//     }

//     public function getId(): ?int
//     {
//         return $this->id;
//     }

//     public function getUsername(): ?string
//     {
//         return $this->username;
//     }

//     public function setUsername(string $username): static
//     {
//         $this->username = $username;

//         return $this;
//     }

//     /**
//      * A visual identifier that represents this user.
//      *
//      * @see UserInterface
//      */
//     public function getUserIdentifier(): string
//     {
//         return (string) $this->username;
//     }

//     /**
//      * @see UserInterface
//      *
//      * @return list<string>
//      */
//     public function getRoles(): array
//     {
//         $roles = $this->roles;
//         // guarantee every user at least has ROLE_USER
//         $roles[] = 'ROLE_USER';

//         return array_unique($roles);
//     }

//     /**
//      * @param list<string> $roles
//      */
//     public function setRoles(array $roles): static
//     {
//         $this->roles = $roles;

//         return $this;
//     }

//     /**
//      * @see PasswordAuthenticatedUserInterface
//      */
//     public function getPassword(): string
//     {
//         return $this->password;
//     }

//     public function setPassword(string $password): static
//     {
//         $this->password = $password;

//         return $this;
//     }

//     /**
//      * @see UserInterface
//      */
//     public function eraseCredentials(): void
//     {
//         // If you store any temporary, sensitive data on the user, clear it here
//         // $this->plainPassword = null;
//     }

//     public function getFirstname(): ?string
//     {
//         return $this->firstname;
//     }

//     public function setFirstname(string $firstname): static
//     {
//         $this->firstname = $firstname;

//         return $this;
//     }

//     public function getLastname(): ?string
//     {
//         return $this->lastname;
//     }

//     public function setLastname(?string $lastname): static
//     {
//         $this->lastname = $lastname;

//         return $this;
//     }

//     public function getImageProfile(): ?string
//     {
//         return $this->imageProfile;
//     }

//     public function setImageProfile(?string $imageProfile): static
//     {
//         $this->imageProfile = $imageProfile;

//         return $this;
//     }

//     public function getImageCover(): ?string
//     {
//         return $this->imageCover;
//     }

//     public function setImageCover(?string $imageCover): static
//     {
//         $this->imageCover = $imageCover;

//         return $this;
//     }

//     public function getCity(): ?string
//     {
//         return $this->city;
//     }

//     public function setCity(?string $city): static
//     {
//         $this->city = $city;

//         return $this;
//     }

//     public function getCountry(): ?string
//     {
//         return $this->country;
//     }

//     public function setCountry(?string $country): static
//     {
//         $this->country = $country;

//         return $this;
//     }

//     public function getGender(): ?string
//     {
//         return $this->gender;
//     }

//     public function setGender(?string $gender): static
//     {
//         $this->gender = $gender;

//         return $this;
//     }

//     /**
//      * @return Collection<int, Posts>
//      */
//     public function getPosts(): Collection
//     {
//         return $this->posts;
//     }

//     public function addPost(Posts $post): static
//     {
//         if (!$this->posts->contains($post)) {
//             $this->posts->add($post);
//             $post->setUserId($this);
//         }

//         return $this;
//     }

//     public function removePost(Posts $post): static
//     {
//         if ($this->posts->removeElement($post)) {
//             // set the owning side to null (unless already changed)
//             if ($post->getUserId() === $this) {
//                 $post->setUserId(null);
//             }
//         }

//         return $this;
//     }

//     /**
//      * @return Collection<int, ContentType>
//      */
//     public function getContentTypes(): Collection
//     {
//         return $this->contentTypes;
//     }

//     public function addContentType(ContentType $contentType): static
//     {
//         if (!$this->contentTypes->contains($contentType)) {
//             $this->contentTypes->add($contentType);
//             $contentType->setUserId($this);
//         }

//         return $this;
//     }

//     public function removeContentType(ContentType $contentType): static
//     {
//         if ($this->contentTypes->removeElement($contentType)) {
//             // set the owning side to null (unless already changed)
//             if ($contentType->getUserId() === $this) {
//                 $contentType->setUserId(null);
//             }
//         }

//         return $this;
//     }

//     /**
//      * @return Collection<int, Categories>
//      */
//     public function getCategories(): Collection
//     {
//         return $this->categories;
//     }

//     public function addCategory(Categories $category): static
//     {
//         if (!$this->categories->contains($category)) {
//             $this->categories->add($category);
//             $category->setUserId($this);
//         }

//         return $this;
//     }

//     public function removeCategory(Categories $category): static
//     {
//         if ($this->categories->removeElement($category)) {
//             // set the owning side to null (unless already changed)
//             if ($category->getUserId() === $this) {
//                 $category->setUserId(null);
//             }
//         }

//         return $this;
//     }

//     public function getEmail(): ?string
//     {
//         return $this->email;
//     }

//     public function setEmail(?string $email): static
//     {
//         $this->email = $email;

//         return $this;
//     }
// }
