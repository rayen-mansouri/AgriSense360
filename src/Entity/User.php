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

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string', length: 50)]
    private string $status = 'pending';

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

    #[ORM\Column(name: 'reset_token', type: 'string', length: 255, nullable: true)]
    private ?string $resetToken = null;

    #[ORM\Column(name: 'reset_token_expires_at', type: 'datetime', nullable: true)]
    private ?\DateTime $resetTokenExpiresAt = null;

    #[ORM\Column(nullable: true)]
    private ?string $cvFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $aiSuggestedRole = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $decisionReason = null;

    #[ORM\Column(nullable: true)]
    private ?int $approvedBy = null;

    #[ORM\ManyToOne(targetEntity: Farm::class)]
    #[ORM\JoinColumn(name: 'farm_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Farm $farm = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $pendingNotification = null;

    public function getId(): ?int { return $this->id; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }

    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(?string $phone): self { $this->phone = $phone; return $this; }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = array_values($roles);
        return $this;
    }

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

    public function getResetToken(): ?string { return $this->resetToken; }
    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;
        return $this;
    }

    public function getResetTokenExpiresAt(): ?\DateTime { return $this->resetTokenExpiresAt; }
    public function setResetTokenExpiresAt(?\DateTime $resetTokenExpiresAt): self
    {
        $this->resetTokenExpiresAt = $resetTokenExpiresAt;
        return $this;
    }

    public function getCvFile(): ?string { return $this->cvFile; }
    public function setCvFile(?string $cvFile): self { $this->cvFile = $cvFile; return $this; }

    public function getAiSuggestedRole(): ?string { return $this->aiSuggestedRole; }
    public function setAiSuggestedRole(?string $aiSuggestedRole): self { $this->aiSuggestedRole = $aiSuggestedRole; return $this; }

    public function getDecisionReason(): ?string { return $this->decisionReason; }
    public function setDecisionReason(?string $decisionReason): self { $this->decisionReason = $decisionReason; return $this; }

    public function getApprovedBy(): ?int { return $this->approvedBy; }
    public function setApprovedBy(?int $approvedBy): self { $this->approvedBy = $approvedBy; return $this; }

    public function getFarm(): ?Farm { return $this->farm; }
    public function setFarm(?Farm $farm): self { $this->farm = $farm; return $this; }

    public function getPendingNotification(): ?string { return $this->pendingNotification; }
    public function setPendingNotification(?string $msg): self { $this->pendingNotification = $msg; return $this; }
}

