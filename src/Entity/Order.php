<?php

  namespace Recruitment\Entity;

use Recruitment\Cart\Cart;

class Order
{
    private $orderId;
    private $orderItems = [];
    private $totalPrice;

    public function __construct(int $orderId, Cart $cart)
    {
        $this->orderId = $orderId;
        $this->orderItems = $cart->getItems();
        $this->totalPrice = $cart->getTotalPrice();
    }

    public function getDataForView():array
    {
        $view = [];

        $view['id'] = $this->orderId;
        foreach ($this->orderItems as $item) {
            $viewItem['id'] = $item->getProduct()->getId();
            $viewItem['quantity'] = $item->getQuantity();
            $viewItem['total_price'] = $item->getTotalPrice();

            $view['items'][] = $viewItem;
        }
        $view['total_price'] = $this->totalPrice;

        return $view;
    }
}
