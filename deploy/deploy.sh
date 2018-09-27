#!/usr/bin/env bash

# Ensure if any command fails your entire build script fails
set -eo pipefail

# Go to the deploy folder
cd deploy

# Download composer
curl -sS https://getcomposer.org/installer | php

# Install composer
php composer.phar update

# Launch deployer
vendor/bin/dep deploy develop --tag=develop

# Clean up
rm -f composer.phar