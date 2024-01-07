#!/bin/bash

set -eo pipefail
shopt -s nullglob

CONFIG_FOLDER=/srv/app/app/config

source "$(dirname "$0")/util/logging.sh"

function webapi_call() {
    FLAG="$1"
    ADDRESS="$2"

    FLAG_FILE_PATH="$CONFIG_FOLDER/flag_$FLAG"
    if test -f "$FLAG_FILE_PATH"; then
        FLAG_NO_FILE_PATH="$CONFIG_FOLDER/flag_no_$FLAG"
        if test -f "$FLAG_NO_FILE_PATH"; then
            webbox_error "Please remove the $FLAG_NO_FILE_PATH first. Both flag and noflag are not allowed."
        fi
        webbox_note "Flag $FLAG exists. Reading transactions..."
        if ! wget -q -O /dev/null -Y off $ADDRESS; then
            webbox_error "Failure contacting server"
        else
            webbox_note "Success contacting server"
        fi
    fi
}
