<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'user_sessions')]
class UserSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $session_id = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private ?string $session_token = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $ip_address = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $last_activity = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $expires_at = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $is_active = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $device_info = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionId(): ?int
    {
        return $this->session_id;
    }

    public function setSessionId(?int $session_id): static
    {
        $this->session_id = $session_id;

        return $this;
    }

    public function getSessionToken(): ?string
    {
        return $this->session_token;
    }

    public function setSessionToken(string $session_token): static
    {
        $this->session_token = $session_token;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ip_address;
    }

    public function setIpAddress(?string $ip_address): static
    {
        $this->ip_address = $ip_address;

        return $this;
    }

    public function getLastActivity(): ?\DateTime
    {
        return $this->last_activity;
    }

    public function setLastActivity(\DateTime $last_activity): static
    {
        $this->last_activity = $last_activity;

        return $this;
    }

    public function getExpiresAt(): ?\DateTime
    {
        return $this->expires_at;
    }

    public function setExpiresAt(\DateTime $expires_at): static
    {
        $this->expires_at = $expires_at;

        return $this;
    }

    public function getIsActive(): ?int
    {
        return $this->is_active;
    }

    public function setIsActive(?int $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getDeviceInfo(): ?string
    {
        return $this->device_info;
    }

    public function setDeviceInfo(?string $device_info): static
    {
        $this->device_info = $device_info;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

}
