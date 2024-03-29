<?php
// Show php.ini file loaded

$ini = php_ini_loaded_file();

echo "php.ini file loaded $ini".PHP_EOL;

// The php.ini setting phar.readonly must be set to 0
$pharFile = 'red-blue-moon.phar';

// clean up
if (file_exists($pharFile)) {
    unlink($pharFile);
}
if (file_exists($pharFile . '.gz')) {
    unlink($pharFile . '.gz');
}

// create phar
$p = new Phar($pharFile);

// creating our library using whole directory  
$p->buildFromDirectory('app/');

// pointing main file which requires all classes  
$p->setDefaultStub('index.php', '/index.php');

// plus - compressing it into gzip  
$p->compress(Phar::GZ);
   
echo "$pharFile successfully created".PHP_EOL;