#!/bin/bash
if [[ $1 == "" ]]; then
    echo "Usage: $0 <container_name> <timeout>"
    exit 1
fi
CONTAINER=$1
if [[ $2 == "" ]]; then
    echo "Usage: $0 <container_name> <timeout>"
    exit 1
fi
TIMEOUT=$2
if [[ ! $TIMEOUT =~ [0-9]+ ]]; then
    echo "Error: Timeout is not a valid number."
    exit 1
fi
C=0
while true; do
    if [[ ${C} == ${TIMEOUT} ]]; then
        break
    fi
    if [[ $(docker ps | grep $CONTAINER | grep "healthy") != "" ]]; then
        break
    fi
    C=$((C+1))
    sleep 1
done
