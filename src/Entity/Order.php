<?php

  namespace Recruitment\Entity;

  use Recruitment\Cart\Cart;

class Order
{
    private $orderId;
    private $orderItems;
    private $totalPrice;
    private $totalGrossPrice;

    public function __construct(int $orderId, Cart $cart)
    {
        $this->orderId = $orderId;
        $this->orderItems = $cart->getItems();
        $this->totalPrice = $cart->getTotalPrice();
        $this->totalGrossPrice = $cart->getTotalPriceGross();
    }

    public function getDataForView(): array
    {
        $view = [];

        $view['id'] = $this->orderId;
        foreach ($this->orderItems as $item) {
            $viewItem['id'] = $item->getProduct()->getId();
            $viewItem['quantity'] = $item->getQuantity();
            $viewItem['tax'] = $item->getProduct()->getTax();
            $viewItem['total_price'] = $item->getTotalPrice();
            $viewItem['total_gross_price'] = $item->getTotalPriceGross();

            $view['items'][] = $viewItem;
        }
        $view['total_price'] = $this->totalPrice;
        $view['total_gross_price'] = $this->totalGrossPrice;

        return $view;
    }
}
