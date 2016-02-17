#!/usr/bin/env bash
composer install --no-interaction
mkdir kushkiTest
cp -f out/artifacts/Kushki/kushki-$SNAP_PIPELINE_COUNTER.zip kushkiTest
cd kushkiTest
unzip -o kushki-$SNAP_PIPELINE_COUNTER.zip
cp -rf ../tests .
cp -f ../phpunit.xml .
phpunit --configuration phpunit.xml --testsuite integration