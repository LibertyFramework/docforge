#!/usr/bin/env bash

mkdir -p $1 > /dev/null 2>&1 & cd $1
echo '{"directory": "vendor"}' > .bowerrc
bower install uikit angular angular-ui-router