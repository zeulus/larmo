#!/bin/bash

set -e

WORKDIR="/var/www/html"

if [ -f "$WORKDIR/bower.json" ]; then
    cd "$WORKDIR"
    bower install --allow-root
fi

cd "$WORKDIR"
sed -i.bak 's|"url": "[^"]*"|"url": "http://'"$HUB_PORT_80_TCP_ADDR"'"|g' src/config.js

exec "$@"