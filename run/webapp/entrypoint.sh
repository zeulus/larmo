#!/bin/bash

set -e

WORKDIR="/var/www/html"

if [ -f "$WORKDIR/bower.json" ]; then
    cd $WORKDIR
    bower install --allow-root
fi

exec "@$"