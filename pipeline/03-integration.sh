#!/usr/bin/env bash
composer install --no-interaction
mkdir kushkiTest
cp -f out/artifacts/Kushki/kushki-dev.zip kushkiTest
cd kushkiTest
unzip -o kushki-dev.zip
cp -rf ../tests .
cp -f ../phpunit.xml .
phpunit --configuration phpunit.xml --testsuite integration
