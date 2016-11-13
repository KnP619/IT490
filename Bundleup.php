<?php

if($argc != 3 ){
	echo $argc;
	echo "Usage:php Bundleup.php <full path of .ini> <name/version>" . PHP_EOL;
}
else{
	$file = fopen("$argv[1]", "r") or die("Unable to open file!");
	$archive = new PharData($argv[2].'.tar');
	//$archive->addFile('text.txt');
	$parse = parse_ini_file("$argv[1]",true);
	mkdir('update',0777,true);
	foreach($parse as $arr){
		foreach($arr as $source){
			$key = array_search($source, $arr);
			copy($source, __DIR__.'/update/'.$key);
			//echo 'Key: ' .$key . PHP_EOL;
			//echo $val . PHP_EOL;

		}
	}
	exec("cp $argv[1] " .__DIR__."/update/bundle.ini");
	$archive->buildFromDirectory(dirname(__FILE__) . '/update');
	//$archive->compress(Phar::GZ);
	exec('rm -r update');
	echo "Done!" .PHP_EOL;
}
?>