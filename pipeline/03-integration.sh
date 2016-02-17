#!/usr/bin/env bash
composer install --no-interaction
ls ../
mkdir ../kushkiTest
cp out/artifacts/Kushki/kushki-$SNAP_PIPELINE_COUNTER.zip ../kushkiTest
ls ../kushkiTest
unzip ../kushkiTest/kushki-$SNAP_PIPELINE_COUNTER.zip
ls ../kushkiTest
cp -r tests ../kushkiTest
cp phpunit.xml ../kushkiTest
cd ../kushkiTest
ls
phpunit --configuration phpunit.xml --testsuite integration