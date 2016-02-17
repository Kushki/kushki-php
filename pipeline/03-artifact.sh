#!/usr/bin/env bash
zip -r kushki-$SNAP_PIPELINE_COUNTER.zip * --exclude='*.git*' --exclude='*test*' --exclude='README.md' --exclude='runTest.sh' --exclude='*.iml*' --exclude='phpunit.xml' --exclude='*reports*' --exclude='*pipeline*'
mv kushki-$SNAP_PIPELINE_COUNTER.zip out/artifacts/Kushki
git add out/artifacts/Kushki/
git commit -m '[snap-ci] adding latest version of zip, pipeline '$SNAP_PIPELINE_COUNTER
git config --global push.default simple
git pull --rebase
git push
