#!/usr/bin/env bash
git add out/artifacts/Kushki/
git commit -m '[snap-ci] adding latest version of zip, pipeline '$SNAP_PIPELINE_COUNTER
git config --global push.default simple
git pull --rebase
git push