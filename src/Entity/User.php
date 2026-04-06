<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'user')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $name = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $password = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $phone = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $roles = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $status = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $auth_provider = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $google_id = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $profile_picture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function setRoles(string $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAuthProvider(): ?string
    {
        return $this->auth_provider;
    }

    public function setAuthProvider(string $auth_provider): static
    {
        $this->auth_provider = $auth_provider;

        return $this;
    }

    public function getGoogleId(): ?string
    {
        return $this->google_id;
    }

    public function setGoogleId(?string $google_id): static
    {
        $this->google_id = $google_id;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profile_picture;
    }

    public function setProfilePicture(?string $profile_picture): static
    {
        $this->profile_picture = $profile_picture;

        return $this;
    }

}
