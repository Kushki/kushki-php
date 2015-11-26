# kushki-php

###Para usar la librería se necesita
  - Clonar el repositorio
```sh
git clone git@github.com:Kushki/kushki-php.git
```
  - Descargar dependencias de la libreria con Composer (el ejecutable de composer se encuentra en la raiz del repositorio, 
  o si desea puede descargarlo de https://getcomposer.org/doc/00-intro.md)
```sh
php composer.phar install
```
  - Incluir autoload.php en su proyecto, el fichero se encuentra en la carpeta raiz de la librería
```sh
include_once("kushki/autoload.php");
```
  - Cree un objeto Kushki en su codigo y use los metodos deseados
```sh
$merchantId = < id del comercio >;
$idioma = KushkiLanguage::ES;
$moneda = KushkiCurrencies::USD;
$kushki = new Kushki( $merchantId, $idioma, $moneda);
$token = < token enviado desde el navegador >;
$monto = < monto a pagar >;
$transaccion = $kushki->charge($token, $monto);

if ($transaction->isSuccessful()){
  echo  “Número de ticket: ” .  $transaction->getTicketNumber();
} else {
  echo “Mensaje de error: ” . $transaction->getResponseText();
}
```

###Para correr las pruebas con phpunit
  - Instalar phpunit como se indica aqui: https://phpunit.de/manual/current/en/installation.html
```sh
wget https://phar.phpunit.de/phpunit.phar
chmod +x phpunit.phar
sudo mv phpunit.phar /usr/local/bin/phpunit
phpunit --version
```  
  - Correr pruebas
```sh
./runTest.sh
```

###Para generar reportes de cobertura de pruebas debe:
  - Instalar xdebug con el asistente http://xdebug.org/wizard.php
  - Crear una carpeta para almacenar los reportes, por ejemplo "reports"
  - Agrega o quita el parametro "--coverage-html reports" a la linea de ejecución de phpunit, según se necesite 

------------------------------------ENGLISH-----------------------------------------------

###For use library need
  - Clone repository
```sh
git clone git@github.com:Kushki/kushki-php.git
```
  - Download dependencies with Composer (we have composer phar inside repo folder, or you can use 
  https://getcomposer.org/doc/00-intro.md)
```sh
php composer.phar install
```
  - Include autoload.php in your project, file is inside library root folder
```sh
include_once("kushki/autoload.php");
```
  - Create new Kushki object in your code and use needed methods
```sh
$merchantId = < id of the merchant >;
$language = KushkiLanguage::ES;
$currency = KushkiCurrencies::USD;
$kushki = new Kushki( $merchantId, $language, $currency);
$token = < token received >;
$amount = < amount >;
$transaccion = $kushki->charge($token, $amount);

if ($transaction->isSuccessful()){
  echo  “Ticket number: ” .  $transaction->getTicketNumber();
} else {
  echo “Error message: ” . $transaction->getResponseText();
}
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
  - Add or Remove parameter "--coverage-html reports" to phpunit execution line 
