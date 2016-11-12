<?php
$file = fopen("bundle.ini", "r") or die("Unable to open file!");
$archive = new PharData('Backend.tar');
//$archive->addFile('text.txt');
//$archive->compress(Phar::GZ);
$parse = parse_ini_file("bundle.ini",true);
mkdir('update',0777,true);
foreach($parse as $arr){
    foreach($arr as $source){
		$key = array_search($source, $arr);
		copy($source, __DIR__.'/update/'.$key);
		//echo 'Key: ' .$key . PHP_EOL;
		//echo $val . PHP_EOL;
		
	}
}
copy("bundle.ini",__DIR__.'/update/bundle.ini');
$archive->buildFromDirectory(dirname(__FILE__) . '/update');
//$archive->compress(Phar::GZ);
rmdir('update');

?>