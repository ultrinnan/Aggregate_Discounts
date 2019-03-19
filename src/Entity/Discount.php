<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Discount
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $programId;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $shop;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $value;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $discount;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $currency;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $commissionValueFormatted;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $url;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $validFromDate;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $expireDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $dateFound;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getProgramId(): int
    {
        return $this->programId;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return \DateTime
     */
    public function getDateFound(): \DateTime
    {
        return $this->dateFound;
    }

    /**
     * @return \DateTime
     */
    public function getExpireDate(): \DateTime
    {
        return $this->expireDate;
    }

    /**
     * @return string
     */
    public function getShop(): string
    {
        return $this->shop;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return \DateTime
     */
    public function getValidFromDate(): \DateTime
    {
        return $this->validFromDate;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getCommissionValueFormatted(): string
    {
        return $this->commissionValueFormatted;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getDiscount(): string
    {
        return $this->discount;
    }

    /**
     * @param int $programId
     */
    public function setProgramId(int $programId): void
    {
        $this->programId = $programId;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @param \DateTime $dateFound
     */
    public function setDateFound(\DateTime $dateFound): void
    {
        $this->dateFound = $dateFound;
    }

    /**
     * @param \DateTime $expireDate
     */
    public function setExpireDate(\DateTime $expireDate): void
    {
        $this->expireDate = $expireDate;
    }

    /**
     * @param string $shop
     */
    public function setShop(string $shop): void
    {
        $this->shop = $shop;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @param \DateTime $validFromDate
     */
    public function setValidFromDate(\DateTime $validFromDate): void
    {
        $this->validFromDate = $validFromDate;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @param string $commissionValueFormatted
     */
    public function setCommissionValueFormatted(string $commissionValueFormatted): void
    {
        $this->commissionValueFormatted = $commissionValueFormatted;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @param string $discount
     */
    public function setDiscount(string $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist(): void
    {
        $this->dateFound = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate(): void
    {
        $this->dateFound = new \DateTime("now");
    }

    public function update(Discount $discount): void
    {
        $this->setShop($discount->getShop());
        $this->setCode($discount->getCode());
        $this->setProgramId($discount->getProgramId());
        $this->setValue($discount->getValue());
        $this->setUrl($discount->getUrl());
        $this->setDiscount($discount->getDiscount());
        $this->setCurrency($discount->getCurrency());
        $this->setCommissionValueFormatted($discount->getCommissionValueFormatted());
        $this->setValidFromDate($discount->getValidFromDate());
        $this->setExpireDate($discount->getExpireDate());
        $this->setDateFound($discount->getDateFound());
    }
}
