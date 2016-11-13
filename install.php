<?php
if($argc != 2){
	die("Usage: php install.php <path/to/tar.tar>".PHP_EOL);
	}
else{
	$arch = new PharData("$argv[1]");
	mkdir('update',0777,true);
	$arch->extractTo(__DIR__.'/update/',null,true);
	$file = fopen(__DIR__.'/update/bundle.ini', "r") or die("Unable to open file!");
	$parse = parse_ini_file(__DIR__."/update/bundle.ini", true);
	$check = 0;
	foreach($parse as $arr){
		foreach($arr as $dest){
			if(!file_exists($dest) && $check == 0){
				mkdir(dirname($dest),0777,true);
				$check++;
			}
			$key = array_search($dest, $arr);
			if(copy(__DIR__.'/update/'.$key, $dest)){
				echo "copied to $dest" . PHP_EOL;
				unlink(__DIR__.'/update/'.$key);
			}
			else{
				die("Copy failed".PHP_EOL);
			}
		}
	}
	unlink(__DIR__.'/update/bundle.ini');
	exec("rmdir update");
}
?>