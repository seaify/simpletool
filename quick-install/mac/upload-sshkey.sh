#!/bin/sh
ssh-keygen -t rsa
brew install ssh-copy-id
ssh-copy-id chuck@104.236.51.112
ssh chuck@104.236.51.112
