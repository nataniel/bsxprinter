<?php
namespace Nataniel\BsxPrinter;

class Export
{
    /**
     * @var Receipt[]
     */
    protected $receipts = [];

    /**
     * @param Receipt[] $receipts
     */
    public function __construct($receipts = [])
    {
        foreach ($receipts as $receipt) {
            $this->addReceipt($receipt);
        }
    }

    /**
     * @param  Receipt $receipt
     * @return $this
     */
    public function addReceipt(Receipt $receipt)
    {
        $this->receipts[] = $receipt;
        return $this;
    }

    /**
     * @return \SimpleXMLElement
     * @throws \Exception
     */
    public function toXML()
    {
        $root = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root></root>');

        $receiptsNode = $root->addChild('receipts');
        foreach ($this->receipts as $receipt) {
            Xml::addChild($receiptsNode, $receipt->toXML());
        }

        return $root;
    }
}