#!/usr/bin/env bash
composer install --no-interaction
phpunit --configuration phpunit.xml --testsuite integration