<?php

include 'interface.php';

include 'DocumentStore.php';

include 'HtmlDocument.php';

include 'CommandOutputDocument.php';



$documentStore = new DocumentStore();

$htmlDoc = new HtmlDocument("http://php.net");
$documentStore->addDocument($htmlDoc);

$cmdDoc = new CommandOutputDocument(' cat /etc/hosts');
$documentStore->addDocument($cmdDoc);

print_r($documentStore->getDocuments());
