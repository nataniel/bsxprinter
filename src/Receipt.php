<?php
namespace Nataniel\BsxPrinter;

/**
 * $receipt = new BsxPrinter\Receipt($id, 'ZS-12345');
 * $receipt->setNIP('5422485927');
 * $receipt->addItem('Osadnicy z Catanu', 99, 1, 23)
 *         ->addItem('Dobble', 59.95, 2, 23);
 *
 * echo $receipt->toXML()->asXml();
 *
 * Class Receipt
 * @package Nataniel\BsxPrinter
 */
class Receipt
{
    /** @var mixed */
    protected $id;

    /** @var mixed */
    protected $symbol;

    /** @var string */
    protected $nip;

    /** @var Receipt\Item[] */
    protected $items = [];

    public function __construct($id, $symbol = null)
    {
        $this->id = $id;
        $this->symbol = $symbol;
    }

    /**
     * @return Receipt\Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @todo   validate NIP?
     * @param  string $nip
     * @return $this
     */
    public function setNIP($nip)
    {
        $this->nip = $nip;
        return $this;
    }

    /**
     * @param  string $name
     * @param  float $price
     * @param  int $quantity
     * @param  int $vat
     * @param  int
     * @return $this
     */
    public function addItem($name, $price, $quantity, $vat, ?int $discountPercent = null)
    {
        $this->items[] = new Receipt\Item($name, $price, $quantity, $vat, $discountPercent);
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            # echo $item->getLineAmount() . "<br />";
            $total += $item->getLineAmount();
        }

        # echo $total; exit();
        return $total;
    }

    /**
     * @return \SimpleXMLElement
     * @throws \Exception
     */
    public function toXML()
    {
        $root = new \SimpleXMLElement('<receipt></receipt>');
        $root->addAttribute('id', $this->id);
        if (!is_null($this->symbol)) {
            $root->addAttribute('symbol', $this->symbol);
        }

        $now = new \DateTime('now');
        $root->addAttribute('total', sprintf('%.2f', $this->getTotalAmount()));
        $root->addAttribute('total2', sprintf($this->getTotalAmount()));
        $root->addAttribute('cash', sprintf('%.2f', $this->getTotalAmount()));
        $root->addAttribute('date', $now->format('Y-m-d'));

        if ($this->nip) {
            $root->addAttribute('nip', $this->nip);
        }

        foreach ($this->items as $item) {
            if ($item->getPrice() > 0) {
                Xml::addChild($root, $item->toXML());
            }
        }

        return $root;
    }

    /**
     * @return string
     */
    public function getNIP()
    {
        return $this->nip;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSymbol()
    {
        return $this->symbol;
    }
}