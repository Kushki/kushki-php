# kushki-php

###For use library need
  - Clone repository
  - Include autoload.php in the library root folder
  - Create new Kushki object
  - Call the method needed with required parameters

###For run test with phpunit
```sh
./runTest.sh
```

###For update dependencies with composer
```sh
php composer.phar install

###For generate test coverage report need to:
  - Install xdebug with wizard http://xdebug.org/wizard.php
  - Create a folder for save reports, example "reports"
  - Add parameter "--coverage-html reports" to phpunit execution line 
```

