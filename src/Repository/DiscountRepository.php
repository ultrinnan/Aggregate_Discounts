<?php

namespace App\Repository;

use App\Entity\Discount;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @package App\Repository
 */
class DiscountRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ObjectRepository
     */
    private $objectRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(Discount::class);
    }

    public function findById(int $discountId): ?Discount
    {
        $discount = $this->objectRepository->find($discountId);
        if (!$discount) {
            throw new EntityNotFoundException('Discount with id '.$discountId.' does not exist!');
        }

        return $discount;
    }

    public function getId(Discount $discount): int
    {
        return $discount->getId();
    }

    public function findAll(): array
    {
        return $this->objectRepository->findAll();
    }

    public function findUnsubmitted(): array
    {
        return $this->objectRepository->findBy(['submitted' => false]);
    }

    public function create(Discount $discount): Discount
    {
        $discount->update($discount);

        $this->entityManager->persist($discount);
        $this->entityManager->flush();

        return $discount;
    }

    public function update(Discount $discount): Discount
    {
        if (!$discount->getId()) {
            throw new EntityNotFoundException('Id should be provided for update methods');
        }
        
        $item = $this->findById($discount->getId());
        if (!$item) {
            throw new EntityNotFoundException('Discount with id '.$discount->getId().' does not exist!');
        }
        
        $item->update($discount);
        $this->entityManager->merge($item);
        $this->entityManager->flush();
        return $discount;
    }

    public function delete(int $discountId): void
    {
        $discount = $this->findById($discountId);
        if (!$discount) {
            throw new EntityNotFoundException('Discount with id '. $discountId .' does not exist!');
        }

        $this->entityManager->remove($discount);
        $this->entityManager->flush();
    }
}
