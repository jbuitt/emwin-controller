#!/bin/bash
if [[ $1 == "" ]]; then
   echo "Usage: $0 /path/to/product"
   exit 1
fi
if [[ -z $EMWIN_BASE_DIR ]]; then
   echo "The environment variable \$EMWIN_BASE_DIR is not set."
   exit 0
fi
cd $EMWIN_BASE_DIR/
./artisan emwin-controller:pan-run $1
