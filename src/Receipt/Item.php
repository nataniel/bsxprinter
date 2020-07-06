<?php
namespace Nataniel\BsxPrinter\Receipt;

class Item
{
    const DISCOUNT_TYPE = 0;

    protected $name, $price, $quantity, $vat, $discountPercent;

    public function __construct($name, $price, $quantity, $vat, ?int $discountPercent = null)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->vat = $vat;
        $this->discountPercent = $discountPercent;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getVAT()
    {
        return $this->vat;
    }

    /**
     * @return float
     */
    public function getLineAmount()
    {
        return round(floor($this->price * $this->quantity * (100 - $this->discountPercent)) / 100,2);
    }

    public function getDiscountValue()
    {
        return $this->price * $this->quantity - $this->getLineAmount();
    }

    /**
     * @return \SimpleXMLElement
     */
    public function toXML()
    {
        $root = new \SimpleXMLElement('<item></item>');
        $root->addAttribute('name', $this->name);
        $root->addAttribute('vatrate', $this->vat);
        $root->addAttribute('quantity', $this->quantity);

        $root->addAttribute('price', $this->price);
        if ($this->discountPercent > 0) {
            $root->addAttribute('discount', 1);
            $root->addAttribute('discountvalue', $this->getDiscountValue());
            $root->addAttribute('discountname', $this->discountPercent . '%');
            $root->addAttribute('total', $this->getLineAmount());
        }

        # $root->addAttribute('price', sprintf('%.2f', $this->getUnitPrice()));
        # $root->addAttribute('total', sprintf('%.2f', $this->getLineAmount()));
        return $root;
    }
}