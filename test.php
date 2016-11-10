<?php

//var_dump($argv);

$archive = new PharData('archive.tar');
$archive->addFile('text.txt');
$archive->compress(Phar::GZ);
unlink('archive.tar');
?>
