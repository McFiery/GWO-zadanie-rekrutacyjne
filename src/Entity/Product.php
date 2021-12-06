<?php

  namespace Recruitment\Entity;

  use InvalidArgumentException;
  use Recruitment\Entity\Exception\InvalidTaxValue;
  use Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product
{
    private $id;
    private $name;
    private $unitPrice;
    private $minimumQuantity = 1;
    private $tax = 0;

    private $acceptedTax = [0,5,8,23];

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

  /**
   * @param string $name
   * @return Product
   */
    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

  /**
   * @return string
   */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @param int $unitPrice
     * @return Product
     * @throws InvalidUnitPriceException
     */
    public function setUnitPrice(int $unitPrice): Product
    {
        if ($unitPrice > 0) {
            $this->unitPrice = $unitPrice;
        } else {
            throw new InvalidUnitPriceException('UnitPrice must be greater than 0');
        }
        return $this;
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    /**
     * @param int $minimumQuantity
     * @return Product
     */
    public function setMinimumQuantity(int $minimumQuantity): Product
    {
        $productMinimumQuantity = $this->getMinimumQuantity();
        if ($minimumQuantity >= $productMinimumQuantity) {
            $this->minimumQuantity = $minimumQuantity;
        } else {
            throw new InvalidArgumentException('The minimum quantity is to low');
        }
        return $this;
    }

    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

  /**
   * @return int
   */
    public function getTax(): int
    {
        return $this->tax;
    }

  /**
   * @param int $tax
   * @return Product
   * @throws InvalidTaxValue
   */
    public function setTax(int $tax): Product
    {
        if (in_array($tax, $this->acceptedTax)) {
            $this->tax = $tax;
        } else {
            throw new InvalidTaxValue();
        }

        return $this;
    }
}
