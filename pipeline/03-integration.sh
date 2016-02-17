#!/usr/bin/env bash
composer install --no-interaction
echo "ls ../"
ls ../
mkdir ../kushkiTest
cp out/artifacts/Kushki/kushki-$SNAP_PIPELINE_COUNTER.zip ../kushkiTest
echo "ls ../kushkiTest antes de unzip"
ls ../kushkiTest
unzip ../kushkiTest/kushki-$SNAP_PIPELINE_COUNTER.zip
echo "ls ../kushkiTest despues de unzip"
ls ../kushkiTest
cp -r tests ../kushkiTest
cp phpunit.xml ../kushkiTest
cd ../kushkiTest
echo "ls antes de tests"
ls
phpunit --configuration phpunit.xml --testsuite integration