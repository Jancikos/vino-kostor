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

# usage: file_env VAR [DEFAULT]
#    ie: file_env 'XYZ_DB_PASSWORD' 'example'
# (will allow for "$XYZ_DB_PASSWORD_FILE" to fill in the value of
#  "$XYZ_DB_PASSWORD" from a file, especially for Docker's secrets feature)
file_env() {
        local var="$1"
        local fileVar="${var}_FILE"
        local def="${2:-}"
        if [ "${!var:-}" ] && [ "${!fileVar:-}" ]; then
                webbox_error "Both $var and $fileVar are set (but are exclusive)"
        fi
        local val="$def"
        if [ "${!var:-}" ]; then
                val="${!var}"
        elif [ "${!fileVar:-}" ]; then
                val="$(< "${!fileVar}")"
        fi
        export "$var"="$val"
        unset "$fileVar"
}

# usage: def_env VAR [DEFAULT]
#    ie: def_env 'XYZ_DB_HOST' 'example'
# if given var is unset, then it will be set to DEFAULT
def_env() {
        local var="$1"
        local def="${2:-}"
        local val="$def"
        if [ "${!var:-}" ]; then
                val="${!var}"
        fi
        export "$var"="$val"
}

escape() {
        printf '%s\n' "$1" | sed -e 's/[\/&]/\\&/g'
}

# check to see if this file is being run or sourced from another script
_is_sourced() {
        # https://unix.stackexchange.com/a/215279
        [ "${#FUNCNAME[@]}" -ge 2 ] \
                && [ "${FUNCNAME[0]}" = '_is_sourced' ] \
                && [ "${FUNCNAME[1]}" = 'source' ]
}

# Loads various settings that are used elsewhere in the script
# This should be called after mysql_check_config, but before any other functions
docker_setup_env() {
        # Initialize values that might be stored in a file
        file_env 'APP_ENV' 'prod'
        file_env 'APP_SECRET' 'ThisTokenIsSoSecretNigdyChangeIt'
}

check_modules() {
        MODULES_FOLDER=/srv/app/src
        ENABLED_MODULES="$1"
        EN_MODULES_ARR=(${ENABLED_MODULES//,/ })
        REGEXP=$(printf "|%s" "${EN_MODULES_ARR[@]}")
        REGEXP=${REGEXP:1}

        for i in $(find "$MODULES_FOLDER" -mindepth 1 -maxdepth 1 -type d); do
                MODULE_PATH="$i"
                MODULE_NAME="$(basename $i)"
                if [[ "$MODULE_NAME" =~ ^($REGEXP)$ ]]; then
                        webbox_note "$MODULE_NAME exists...ok"
                else
                        webbox_note "$MODULE_NAME not in the enabled list, removing..."
                        rm -rf "$MODULE_PATH"
                fi
        done
}

update_config() {
        sed \
                -e "s/^APP_ENV=.*/APP_ENV=$(escape "${APP_ENV}")/" \
                -e "s/^APP_SECRET=.*/APP_SECRET=$(escape "${APP_SECRET}")/" \
                /srv/app/.\env.dist \
                > /srv/app/.\env

        if [ ! -f "/etc/hosts.orig" ]; then
                cp /etc/hosts /etc/hosts.orig
        fi
}

_main() {
        # if command starts with an option, prepend mysqld
        if [ "${1:0:1}" = '-' ]; then
                set -- caddy "$@"
        fi

        # skip setup if they aren't running web server
        if [[ "$3" == *startup.sh ]]; then
                webbox_note "Entrypoint script for Webbox Server started."

                # Load various environment variables
                docker_setup_env "$@"

                update_config "$@"

                if [ "$WEBBOX_CLEAR_CACHE" = "yes" ]; then
                        webbox_note "WEBBOX_CLEAR_CACHE set. Clearing dev and prod cache on startup..."
                        rm -rf $WEBBOX_FOLDER/var/cache/dev $WEBBOX_FOLDER/var/cache/prod
                fi
                chown nobody:nobody $WEBBOX_FOLDER/var/cache

                mkdir -p /var/log/php81
                mkdir -p /var/log/caddy/ /var/log/crond /var/log/custom_crond /var/log/php_fpm /var/log/sshd /var/log/webbox_websocket
        fi
        exec "$@"
}

# If we are sourced from elsewhere, don't perform any further actions
webbox_note "php docker entryppoint started"
if ! _is_sourced; then
        webbox_note "php docker entrypoiny main starting"
        _main "$@"
fi
