# kushki-php

|   | Build status |
|---|---|
| CI         | [![Build Status](https://snap-ci.com/Kushki/kushki-php/branch/master/build_image)](https://snap-ci.com/Kushki/kushki-php/branch/master) |

## Documentación

[Puedes acceder a la documentación aquí](https://demo.kushkipagos.com/docs/php).

## Para correr las pruebas con phpunit

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

## Para generar reportes de cobertura de pruebas debes:

- Instalar xdebug con el asistente http://xdebug.org/wizard.php
- Crear una carpeta para almacenar los reportes, por ejemplo "reports"
- Agrega o quita el parametro "--coverage-html reports" a la linea de ejecución de phpunit, según se necesite