<?php

  namespace Recruitment\Cart;

  use InvalidArgumentException;
  use Recruitment\Cart\Exception\QuantityTooLowException;
  use Recruitment\Entity\Product;

class Item
{
    private $product;
    private $quantity;

    /**
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        if ($this->product->getMinimumQuantity() <= $quantity) {
            $this->quantity = $quantity;
        } else {
            throw new InvalidArgumentException();
        }
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @throws QuantityTooLowException
     */
    public function setQuantity(int $quantity): Product
    {
        $ProductMinimumQuantity = $this->product->getMinimumQuantity();
        if ($quantity >= $ProductMinimumQuantity) {
            $this->quantity = $quantity;
        } else {
            throw new QuantityTooLowException('The quantity cannot be less than ' . $ProductMinimumQuantity);
        }
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotalPrice(): int
    {
        return $this->calculateTotalPrice();
    }

    public function calculateTotalPrice(): int
    {
        $productPrice = $this->product->getUnitPrice();
        return $productPrice * $this->quantity;
    }

    public function getTotalPriceGross(): int
    {
        return $this->calculateTotalPriceGross();
    }

    private function calculateTotalPriceGross(): int
    {
        $totalPrice = $this->calculateTotalPrice();
        $taxValue=($totalPrice*$this->product->getTax())/100;

        return $totalPrice+$taxValue;
    }
}
