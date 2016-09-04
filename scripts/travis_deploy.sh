#!/usr/bin/env bash

# Deploy only if it's not a pull request
if [ -z "$TRAVIS_PULL_REQUEST" ] || [ "$TRAVIS_PULL_REQUEST" == "false" ]; then
  # Deploy only if we're testing the master branch
  if [ "$TRAVIS_BRANCH" == "master" ]; then
    echo "Deploying $TRAVIS_BRANCH on $TASK_DEFINITION"
    echo "[default]" >> ~/.aws/credentials
    echo "aws_access_key_id=${AWS_ACCESS_KEY}" >> ~/.aws/credentials
    echo "aws_secret_access_key=${AWS_SECRET_ACCESS_KEY}" >> ~/.aws/credentials
    make deploy-staging
  else
    echo "Skipping deploy because it's not an allowed branch"
  fi
else
  echo "Skipping deploy because it's a PR"
fi