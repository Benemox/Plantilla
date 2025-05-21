<?php

namespace App\Card\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Card
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer', unique: true)]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $bank;

    #[ORM\Column(type: 'json')]
    private array $features;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $annualFee;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $transactionFee;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $cardType;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $logo;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $link;

    public function __construct(
        int $id,
        string $name,
        ?string $bank,
        array $features,
        ?string $annualFee,
        ?string $transactionFee,
        ?string $cardType,
        ?string $logo,
        ?string $link
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->bank = $bank;
        $this->features = $features;
        $this->annualFee = $annualFee;
        $this->transactionFee = $transactionFee;
        $this->cardType = $cardType;
        $this->logo = $logo;
        $this->link = $link;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(?string $bank): void
    {
        $this->bank = $bank;
    }

    public function getFeatures(): array
    {
        return $this->features;
    }

    public function setFeatures(array $features): void
    {
        $this->features = $features;
    }

    public function getAnnualFee(): ?string
    {
        return $this->annualFee;
    }

    public function setAnnualFee(?string $annualFee): void
    {
        $this->annualFee = $annualFee;
    }

    public function getTransactionFee(): ?string
    {
        return $this->transactionFee;
    }

    public function setTransactionFee(?string $transactionFee): void
    {
        $this->transactionFee = $transactionFee;
    }

    public function getCardType(): ?string
    {
        return $this->cardType;
    }

    public function setCardType(?string $cardType): void
    {
        $this->cardType = $cardType;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    public function getBonusProgram(): bool
    {
        return isset($this->features['bonus_program']) && $this->features['bonus_program'] === '1';
    }
}
