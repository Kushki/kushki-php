#!/usr/bin/env bash

set -e

artifact_version=$(cat composer.json | grep \"version\": | cut -d'"' -f 4)

cp out/artifacts/Kushki/kushki-dev.zip out/artifacts/Kushki/kushki.zip
mv out/artifacts/Kushki/kushki-dev.zip out/artifacts/Kushki/kushki-$artifact_version.zip
git add out/artifacts/Kushki/
git commit -m "[snap-ci] adding latest version of zip, version: $artifact_version"
git config --global push.default simple
git pull --rebase
git tag --annotate "v$artifact_version" -m "Release for version $artifact_version"
git push --tags
curl -X POST -H 'content-type:application/json' \
    "https://packagist.org/api/update-package?username=kushki&apiToken=$PACKAGIST_API_TOKEN" \
    -d '{"repository":{"url":"https://packagist.org/packages/kushki/kushki-php"}}'


# ENVS:
# PACKAGIST_API_TOKEN
