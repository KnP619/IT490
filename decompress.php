<?php
//decompress from .gz
$decompress = new PharData("archive.tar.gz");
$decompress->decompress();

//extract the archive
$arch = new PharData("archive.tar");
$arch->extractTo('.');
unlink("archive.tar");
?>
