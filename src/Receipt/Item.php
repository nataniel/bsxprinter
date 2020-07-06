<?php
namespace Nataniel\BsxPrinter\Receipt;

class Item
{
    const DISCOUNT_TYPE = 1;

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
        # this is apparenly how NAV rounds
        return floor($this->price * $this->quantity * (100 - $this->discountPercent)) / 100;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function toXML()
    {
        $root = new \SimpleXMLElement('<item></item>');
        $root->addAttribute('name', $this->name);
        $root->addAttribute('price', sprintf('%.2f', $this->price));
        $root->addAttribute('quantity', $this->quantity);
        $root->addAttribute('vatrate', $this->vat);
        $root->addAttribute('total', sprintf('%.2f', $this->getLineAmount()));
        if ($this->discountPercent > 0) {
            $root->addAttribute('discount', self::DISCOUNT_TYPE);
            $root->addAttribute('discountvalueproc', sprintf('%.2f', $this->discountPercent));
        }

        return $root;
    }
}