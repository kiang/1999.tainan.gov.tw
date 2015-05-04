<?php

$xmlWriter = new XMLWriter();
$xmlWriter->openMemory();
$xmlWriter->startDocument('1.0', 'UTF-8');
$xmlWriter->startElement('root');

$xmlWriter->startElement('city_id');
$xmlWriter->writeCData('tainan.gov.tw');
$xmlWriter->endElement();

$xmlWriter->startElement('area');
$xmlWriter->writeCData('北區');
$xmlWriter->endElement();

$xmlWriter->startElement('address_string');
$xmlWriter->writeCData('開元路與勝利路交叉口');
$xmlWriter->endElement();

$xmlWriter->startElement('lat');
$xmlWriter->writeCData('23.0066994');
$xmlWriter->endElement();

$xmlWriter->startElement('long');
$xmlWriter->writeCData('120.2184427');
$xmlWriter->endElement();

$xmlWriter->startElement('email');
$xmlWriter->writeCData('nobody@example.com');
$xmlWriter->endElement();

$xmlWriter->startElement('device_id');
$xmlWriter->writeCData('well?');
$xmlWriter->endElement();

$xmlWriter->startElement('name');
$xmlWriter->writeCData('沒有人');
$xmlWriter->endElement();

$xmlWriter->startElement('phone');
$xmlWriter->writeCData('0800092000');
$xmlWriter->endElement();

$xmlWriter->startElement('service_name');
$xmlWriter->writeCData('髒亂及汙染');
$xmlWriter->endElement();

$xmlWriter->startElement('subproject');
$xmlWriter->writeCData('其他汙染舉發');
$xmlWriter->endElement();

$xmlWriter->startElement('servicedescription');
$xmlWriter->writeCData('這是個測試，請忽略');
$xmlWriter->endElement();

$xmlWriter->startElement('description');
$xmlWriter->writeCData('這是個測試，請忽略');
$xmlWriter->endElement();

$xmlWriter->startElement('pictures');

$xmlWriter->startElement('picture');

$xmlWriter->startElement('description');
$xmlWriter->writeCData('這是 api 測試');
$xmlWriter->endElement();

$xmlWriter->startElement('fileName');
$xmlWriter->writeCData('hello.jpg');
$xmlWriter->endElement();

$xmlWriter->writeElement('file', base64_encode(file_get_contents(__DIR__ . '/tmp/hello.jpg')));

$xmlWriter->endElement();

$xmlWriter->endElement();

$xmlWriter->endElement();

$xml = $xmlWriter->flush(true);

file_put_contents(__DIR__ . '/tmp/request.xml', $xml);

$url = 'http://open1999.tainan.gov.tw:82/ServiceRequestAdd.aspx';
$options = array(
    'http' => array(
        'header' => "Content-type: text/xml\r\n",
        'method' => 'POST',
        'content' => $xml,
    ),
);
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

file_put_contents(__DIR__ . '/tmp/result.xml', $result);
