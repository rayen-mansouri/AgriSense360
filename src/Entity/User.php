<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name = '';

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $email = '';

    #[ORM\Column(type: 'string', length: 255)]
    private string $password = '';

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $roles = 'ROLE_USER';

    #[ORM\Column(type: 'string', length: 50)]
    private string $status = 'active';

    #[ORM\Column(name: 'auth_provider', type: 'string', length: 50, nullable: true)]
    private ?string $authProvider = null;

    #[ORM\Column(name: 'google_id', type: 'string', length: 255, nullable: true)]
    private ?string $googleId = null;

    #[ORM\Column(name: 'profile_picture', type: 'string', length: 255, nullable: true)]
    private ?string $profilePicture = null;

    #[ORM\Column(name: 'first_login', type: 'boolean', options: ['default' => true])]
    private bool $firstLogin = true;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: true)]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: true)]
    private ?\DateTime $updatedAt = null;

    public function getId(): ?int { return $this->id; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }

    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(?string $phone): self { $this->phone = $phone; return $this; }

    public function getRoles(): array { return array_unique([$this->roles, 'ROLE_USER']); }
    public function setRoles(string $roles): self { $this->roles = $roles; return $this; }

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }

    public function getAuthProvider(): ?string { return $this->authProvider; }
    public function setAuthProvider(?string $authProvider): self { $this->authProvider = $authProvider; return $this; }

    public function getGoogleId(): ?string { return $this->googleId; }
    public function setGoogleId(?string $googleId): self { $this->googleId = $googleId; return $this; }

    public function getProfilePicture(): ?string { return $this->profilePicture; }
    public function setProfilePicture(?string $profilePicture): self { $this->profilePicture = $profilePicture; return $this; }

    public function isFirstLogin(): bool { return $this->firstLogin; }
    public function setFirstLogin(bool $firstLogin): self { $this->firstLogin = $firstLogin; return $this; }

    public function getCreatedAt(): ?\DateTime { return $this->createdAt; }
    public function setCreatedAt(?\DateTime $createdAt): self { $this->createdAt = $createdAt; return $this; }

    public function getUpdatedAt(): ?\DateTime { return $this->updatedAt; }
    public function setUpdatedAt(?\DateTime $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }

    public function getUserIdentifier(): string { return $this->email; }
    public function eraseCredentials(): void {}
}