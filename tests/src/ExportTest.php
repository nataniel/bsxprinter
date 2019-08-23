<?php
namespace NatanielTest\BsxPrinter;

use PHPUnit\Framework\TestCase;
use Nataniel\BsxPrinter\Export;
use Nataniel\BsxPrinter\Receipt;

class ExportTest extends TestCase
{
    /** @var Export */
    private $export;

    public function setUp()
    {
        $this->export = new Export();

        $receipt = new Receipt('123', 'ZS-123');
        $receipt->addItem('Osadnicy z Catanu', 99.95, 2, 23);
        $receipt->addItem('Wsiąść do Pociągu', 135, 1, 23);
        $this->export->addReceipt($receipt);

        $receipt = new Receipt('456', 'ZS-456');
        $receipt->addItem('Cywilizacja: Poprzez Wieki', 125, 1, 23);
        $receipt->addItem('Bilet na Festiwal GRAMY', 15, 2, 8);
        $this->export->addReceipt($receipt);
    }

    /**
     * @covers Export::toXML
     * @throws \Exception
     */
    public function testToXML()
    {
        $xml = $this->export->toXML();
        $this->assertInstanceOf(\SimpleXMLElement::class, $xml);
        $this->assertStringStartsWith('<?xml', $xml->asXML());
    }
}