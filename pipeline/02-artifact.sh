#!/usr/bin/env bash
zip -r out/artifacts/Kushki/kushki-dev.zip * --exclude='*.git*' --exclude='*test*' --exclude='README.md' --exclude='runTest.sh' --exclude='*.iml*' --exclude='phpunit.xml' --exclude='*reports*' --exclude='*pipeline*'

# ARTIFACTS:
# ARTIFACT out/artifacts/Kushki/
