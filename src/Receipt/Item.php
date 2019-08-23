<?php
namespace Nataniel\BsxPrinter\Receipt;

class Item
{
    protected $name, $price, $quantity, $vat;

    public function __construct($name, $price, $quantity, $vat)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->vat = $vat;
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
    public function getAmount()
    {
        return $this->price * $this->quantity;
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
        $root->addAttribute('total', sprintf('%.2f', $this->getAmount()));
        return $root;
    }
}