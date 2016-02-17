#!/usr/bin/env bash
composer install --no-interaction
echo "ls "
ls
mkdir kushkiTest
cp -f out/artifacts/Kushki/kushki-$SNAP_PIPELINE_COUNTER.zip kushkiTest
echo "ls kushkiTest antes de unzip"
cd kushkiTest
ls
unzip -o kushki-$SNAP_PIPELINE_COUNTER.zip
echo "ls kushkiTest despues de unzip"
ls
cp -rf ../tests .
cp -f ../phpunit.xml .
echo "ls antes de tests"
ls
phpunit --configuration phpunit.xml --testsuite integration