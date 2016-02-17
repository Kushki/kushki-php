#!/usr/bin/env bash
composer install --no-interaction
echo "ls ../"
ls ../
mkdir ../kushkiTest
cp -f out/artifacts/Kushki/kushki-$SNAP_PIPELINE_COUNTER.zip ../kushkiTest
echo "ls ../kushkiTest antes de unzip"
ls ../kushkiTest
unzip -o ../kushkiTest/kushki-$SNAP_PIPELINE_COUNTER.zip
echo "ls ../kushkiTest despues de unzip"
ls ../kushkiTest
cp -rf tests ../kushkiTest
cp -f phpunit.xml ../kushkiTest
cd ../kushkiTest
echo "ls antes de tests"
ls
phpunit --configuration phpunit.xml --testsuite integration