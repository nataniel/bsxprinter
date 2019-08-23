<?php
namespace NatanielTest\BsxPrinter;

use PHPUnit\Framework\TestCase;
use Nataniel\BsxPrinter\Receipt;

class ReceiptTest extends TestCase
{
    /** @var Receipt */
    private $receipt;

    public function setUp()
    {
        $this->receipt = new Receipt('123', 'ZS-123');
        $this->receipt->addItem('Osadnicy z Catanu', 99.95, 2, 23);
        $this->receipt->addItem('Wsiąść do Pociągu', 135, 1, 23);
    }

    /**
     * @covers Receipt::getTotalAmount
     */
    public function testGetTotalAmount()
    {
        $this->assertEquals(334.9, $this->receipt->getTotalAmount(), '', 0.01);
    }

    /**
     * @covers Receipt::getItems
     */
    public function testGetItems()
    {
        $items = $this->receipt->getItems();
        $this->assertCount(2, $items);
        foreach ($items as $item) {
            $this->assertInstanceOf(Receipt\Item::class, $item);
        }
    }

    /**
     * @covers Receipt::toXML
     * @throws \Exception
     */
    public function testToXML()
    {
        $xml = $this->receipt->toXML();
        $this->assertInstanceOf(\SimpleXMLElement::class, $xml);
        echo $xml->asXML();
    }
}