#!/bin/bash

git add .
git commit -am "publish"
git push

npm publish
