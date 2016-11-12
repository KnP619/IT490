<?php
$arch = new PharData("Backend.tar");
$arch->extractTo('.',null,true);
$file = fopen('bundle.ini', "r") or die("Unable to open file!");
$parse = parse_ini_file("bundle.ini", true);
if(!is_dir('../Backend')){
	mkdir('../Backend',0777,true);}
foreach($parse as $arr){
	foreach($arr as $source){
		$key = array_search($source, $arr);
		if(copy(__DIR__.'/'.$key, $source)){
			echo "copied to $source" . PHP_EOL;
			unlink($key);
		}
	}
}
unlink('bundle.ini');
?>