# BSXPrinter

## Install
```
composer install nataniel/bsxprinter
```

## Create single Receipt
```php
use Nataniel\BsxPrinter;

$receipt = new BsxPrinter\Receipt($id, 'ZS-12345');
$receipt->setNIP('5422485927');
$receipt->addItem('Osadnicy z Catanu', 99, 1, 23)
         ->addItem('Dobble', 59.95, 2, 23);
echo $receipt->toXML()->asXml();
```

## Export Receipts as BSXPrinter compatible XML
```php
$export = new BsxPrinter\Export();
$export->addReceipt($receipt);
echo $export->toXML()->asXml();
```
