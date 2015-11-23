# kushki-php

###For use library need
  - Clone repository
```sh
git clone git@github.com:Kushki/kushki-php.git
```
  - Download dependencies with composer
```sh
php composer.phar install
```
  - Include autoload.php in your project, file is inside library root folder
```sh
include_once("kushki/autoload.php");
```
  - Create new Kushki object in your code and use needed methods
```sh
$kushki = new Kushki();
```

###For run test with phpunit
  - Install phpunit like here: https://phpunit.de/manual/current/en/installation.html
```sh
wget https://phar.phpunit.de/phpunit.phar
chmod +x phpunit.phar
sudo mv phpunit.phar /usr/local/bin/phpunit
phpunit --version
```  
  - Run tests
```sh
./runTest.sh
```


###For generate test coverage report need to:
  - Install xdebug with wizard http://xdebug.org/wizard.php
  - Create a folder for save reports, example "reports"
  - Add parameter "--coverage-html reports" to phpunit execution line 
