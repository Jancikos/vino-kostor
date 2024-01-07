#!/bin/bash

set -eo pipefail
shopt -s nullglob

# logging functions
webbox_log() {
        local type="$1"; shift
        # accept argument string or stdin
        local text="$*"; if [ "$#" -eq 0 ]; then text="$(cat)"; fi
        local dt; dt="$(date --rfc-3339=seconds)"
        printf '%s [%s] [Entrypoint]: %s\n' "$dt" "$type" "$text"
}
webbox_note() {
        webbox_log Note "$@"
}
webbox_warn() {
        webbox_log Warn "$@" >&2
}
webbox_error() {
        webbox_log ERROR "$@" >&2
        exit 1
}

