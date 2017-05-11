<?php
$phar = new Phar(
    '/tmp/trunon.phar',
    FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME
    , "trunon.phar"
    );

$phar->setStub(
    // $phar->createDefaultStub("artisan")
    file_get_contents("phar.php")
);
$phar->compress(Phar::BZ2);
$phar->buildFromDirectory(
    "."// ,
    // "/^supervisord\/run/"
);