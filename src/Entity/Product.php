<?php
  namespace Recruitment\Entity;

  use InvalidArgumentException;
  use Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product
{
    private $id;
    private $unitPrice;
    private $minimumQuantity = 1;

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
    public function getId():int
    {
        return $this->id;
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

    public function getUnitPrice():int
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

    public function getMinimumQuantity():int
    {
        return $this->minimumQuantity;
    }
}
