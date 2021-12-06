<?php

  namespace Recruitment\Cart;

  use OutOfBoundsException;
  use Recruitment\Entity\Order;
  use Recruitment\Entity\Product;

class Cart
{
    private $items = [];

    /**
     * @param Product $product
     * @param int $quantity
     * @return $this
     */
    public function addProduct(Product $product, int $quantity = 1): Cart
    {
        if (count($this->items) > 0) {
            foreach ($this->items as $item) {
                if ($item->getProduct() === $product) {
                    $item->setQuantity($item->getQuantity() + $quantity);
                } else {
                    array_push($this->items, new Item($product, $quantity));
                }
            }
        } else {
            array_push($this->items, new Item($product, $quantity));
        }

        return $this;
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product): void
    {
        foreach ($this->items as $key => $item) {
            if ($item->getProduct() === $product) {
                unset($this->items[$key]);
            }
        }
        $this->items = array_values($this->items);
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(Product $product, int $quantity): Cart
    {
        if (count($this->items) > 0) {
            foreach ($this->items as $item) {
                if ($item->getProduct() === $product) {
                    $item->setQuantity($quantity);
                } else {
                    array_push($this->items, new Item($product, $quantity));
                }
            }
        } else {
            array_push($this->items, new Item($product, $quantity));
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param $id
     * @return Item
     * @throws OutOfBoundsException
     */
    public function getItem($id): Item
    {
        if (!isset($this->items[$id])) {
            throw new OutOfBoundsException('Product is not exist in Cart');
        }
        return $this->items[$id];
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->calculateTotalPrice();
    }

    /**
     * @return int
     */
    private function calculateTotalPrice(): int
    {
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalPrice += $item->getTotalPrice();
        }
        return $totalPrice;
    }

    public function checkout(int $orderId): Order
    {
        $order = new Order($orderId, $this);
        $this->items = [];
        return $order;
    }

    public function getTotalPriceGross(): int
    {
        return $this->calculateTotalPriceGross();
    }

    private function calculateTotalPriceGross(): int
    {
        $totalPriceGross = 0;
        foreach ($this->items as $item) {
            $totalPriceGross += $item->getTotalPriceGross();
        }
        return $totalPriceGross;
    }
}
