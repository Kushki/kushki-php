#!/usr/bin/env bash
set -e

rm -rf vendor
composer install --no-interaction --no-dev
composer archive --format zip --dir out/artifacts/Kushki --file kushki-dev

# ARTIFACTS:
# ARTIFACT out/artifacts/Kushki/
