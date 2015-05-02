<?php

$xmlWriter = new XMLWriter();
$xmlWriter->openMemory();
$xmlWriter->startDocument('1.0', 'UTF-8');
$xmlWriter->startElement('root');

$xmlWriter->startElement('start_date');
$xmlWriter->writeCData('2015-04-01 00:00:00');
$xmlWriter->endElement();

$xmlWriter->startElement('end_date');
$xmlWriter->writeCData(date('Y-m-d H:i:s'));
$xmlWriter->endElement();

$xmlWriter->endElement();

$url = 'http://open1999.tainan.gov.tw:82/ServiceRequestsQuery.aspx';
$options = array(
    'http' => array(
        'header' => "Content-type: text/xml\r\n",
        'method' => 'POST',
        'content' => $xmlWriter->flush(true),
    ),
);
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

$basePath = __DIR__ . "/requests";

$xml = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
foreach ($xml->records->record AS $record) {
    $timeStamp = strtotime($record->requested_datetime);
    $d = date('Y/m/d', $timeStamp);
    $requestPath = "{$basePath}/{$d}";
    if (!file_exists($requestPath)) {
        mkdir($requestPath, 0777, true);
    }
    if (!empty($record->Pictures)) {
        $picCount = 0;
        foreach ($record->Pictures AS $pic) {
            ++$picCount;
            file_put_contents("{$requestPath}/{$record->service_request_id}-{$picCount}.jpg", base64_decode((string) $pic->Picture->file));
        }
        unset($record->Pictures);
    }
    file_put_contents("{$requestPath}/{$record->service_request_id}.json", json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}