# kushki-php

###Para usar la librería se necesita:
  - Clonar el repositorio
```sh
git clone https://github.com/Kushki/kushki-php.git
```
  - Entrar a la carpeta donde se clonó la librería
```sh
cd kushki-php
```

  - Descargar dependencias de la libreria con Composer (el ejecutable de composer se encuentra en la raíz del repositorio,
  o si desea puede descargarlo de https://getcomposer.org/doc/00-intro.md)
```sh
php composer.phar install
```
  - Incluir las clases de Kushki y autoload.php en su proyecto, el fichero se encuentra en la carpeta raiz de la librería
```sh
use kushki\lib\Kushki;
use kushki\lib\KushkiCurrencies;
use kushki\lib\KushkiLanguages;
include_once("autoload.php");
```
  - Cree un objeto Kushki en su codigo y use los metodos deseados
```sh
$merchantId = < id del comercio >;
$idioma = KushkiLanguages::ES;
$moneda = KushkiCurrencies::USD;
$kushki = new Kushki( $merchantId, $idioma, $moneda);
$token = < token enviado desde el navegador >;
$monto = < monto a pagar >;
$transaccion = $kushki->charge($token, $monto);

if ($transaction->isSuccessful()){
   echo "Número de ticket: " . $transaction->getTicketNumber();
   echo "<br/>Monto aprobado: " . $transaction->getBody()->approved_amount;
   echo "<br/>Respuesta: " . $transaction->getResponseText();
} else {
  echo "Mensaje de error: " . $transaction->getResponseText();
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

##------------------------------------ENGLISH-----------------------------------------------

###To use this library you need to:
  - Clone repository
```sh
git clone git@github.com:Kushki/kushki-php.git
```
  - Navigate to the folder where the library was cloned
```sh
cd kushki-php
```

  - Download dependencies with Composer (we have composer.phar inside the repo folder, or you can use
  https://getcomposer.org/doc/00-intro.md)
```sh
php composer.phar install
```
  - Include Kushki classes and autoload.php in your project, the file is inside library root folder
```sh
use kushki\lib\Kushki;
use kushki\lib\KushkiCurrencies;
use kushki\lib\KushkiLanguages;
include_once("kushki/autoload.php");
```
  - Create new Kushki object in your code and use needed methods
```sh
$merchantId = < id of the merchant >;
$language = KushkiLanguages::ES;
$currency = KushkiCurrencies::USD;
$kushki = new Kushki( $merchantId, $language, $currency);
$token = < token received >;
$amount = < amount >;
$transaccion = $kushki->charge($token, $amount);

if ($transaction->isSuccessful()){
   echo "Ticket number: " . $transaction->getTicketNumber();
   echo "<br/>Approved amount: " . $transaction->getBody()->approved_amount;
   echo "<br/>Response text: " . $transaction->getResponseText();
} else {
  echo "Error message: " . $transaction->getResponseText();
}
```

###To run tests with phpunit
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


###To generate test coverage report you need to:
  - Install xdebug with wizard http://xdebug.org/wizard.php
  - Create a folder to save reports, example "reports"
  - Add or Remove parameter "--coverage-html reports" to phpunit execution line
