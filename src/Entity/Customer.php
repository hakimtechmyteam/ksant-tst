<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\GetCustomersController;
use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            controller: GetCustomersController::class,
            normalizationContext: [
                'groups' => ['customer:read'],
            ],
        ),
        new Post(
            denormalizationContext: [
                'groups' => ['customer:write'],
            ],
        ),
    ],
)]
class Customer
{
    final public const GENDER_MALE = 'male';
    final public const GENDER_FEMALE = 'female';
    final public const GENDERS = [self::GENDER_MALE, self::GENDER_MALE];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['customer:read', 'customer:write'])]
    #[Assert\Choice(choices: Customer::GENDERS, message: 'Choose a valid gender.')]
    #[ApiProperty(
        openapiContext: [
            'type' => 'string',
            'enum' => [self::GENDER_MALE, self::GENDER_FEMALE],
            'example' => self::GENDER_MALE,
        ]
    )]
    private ?string $gender = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

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

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
