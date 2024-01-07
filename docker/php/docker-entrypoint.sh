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
        def_env 'MYSQL_HOST' 'mysql'
        def_env 'MYSQL_PORT' '3306'
        file_env 'MYSQL_DB' 'webbox'
        file_env 'MYSQL_USER' 'webbox'
        file_env 'MYSQL_PASSWORD' 'webbox'
        def_env 'MAILER_TRANSPORT' 'smtp'
        def_env 'MAILER_HOST' '127.0.0.1'
        def_env 'MAILER_PORT' '587'
        file_env 'MAILER_USER' 'null'
        file_env 'MAILER_PASSWORD' 'null'
        def_env 'WEBBOX_LOCALE' 'sk'
        def_env 'WEBBOX_LOGO' 'null'
        def_env 'WEBBOX_LOGIN_QRCODE' 'false'
        def_env 'WEBBOX_PDF_ENABLED' 'true'
        def_env 'WEBBOX_TIMEZONE' 'Europe/Bratislava'
        def_env 'WEBBOX_EXT_HOSTADDR' 'dochadzka.top'
        def_env 'WEBBOX_MODULES' 'System'
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
                -e "s/\${MYSQL_HOST}/$(escape "${MYSQL_HOST}")/g" \
                -e "s/\${MYSQL_PORT}/$(escape "${MYSQL_PORT}")/g" \
                -e "s/\${MYSQL_DB}/$(escape "${MYSQL_DB}")/g" \
                -e "s/\${MYSQL_USER}/$(escape "${MYSQL_USER}")/g" \
                -e "s/\${MYSQL_PASSWORD}/$(escape "${MYSQL_PASSWORD}")/g" \
                -e "s/\${MAILER_TRANSPORT}/$(escape "${MAILER_TRANSPORT}")/g" \
                -e "s/\${MAILER_HOST}/$(escape "${MAILER_HOST}")/g" \
                -e "s/\${MAILER_PORT}/$(escape "${MAILER_PORT}")/g" \
                -e "s/\${MAILER_USER}/$(escape "${MAILER_USER}")/g" \
                -e "s/\${MAILER_PASSWORD}/$(escape "${MAILER_PASSWORD}")/g" \
                -e "s/\${WEBBOX_LOCALE}/$(escape "${WEBBOX_LOCALE}")/g" \
                -e "s/\${WEBBOX_LOGO}/$(escape "${WEBBOX_LOGO}")/g" \
                -e "s/\${WEBBOX_LOGIN_QRCODE}/$(escape "${WEBBOX_LOGIN_QRCODE}")/g" \
                -e "s/\${WEBBOX_TIMEZONE}/$(escape "${WEBBOX_TIMEZONE}")/g" \
                /srv/app/app/config/parameters.yml.tmpl \
                > /srv/app/app/config/parameters.yml

        sed -i -e "s/^\(\\s\+\)ip: 192.168.1.152\(\\s*\)$/\1ip: $(escape "${WEBBOX_EXT_HOSTADDR}")\2/" \
                /srv/app/app/config/sys.yml

        if [ ! -f "/etc/hosts.orig" ]; then
                cp /etc/hosts /etc/hosts.orig
        fi

        sed -e "s/^\(127\.0\.0\.1\\s*localhost\)\(\|\\s\+.*\)$/\1\2 $(escape "${WEBBOX_EXT_HOSTADDR}")/" \
                /etc/hosts.orig > /etc/hosts
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

                # Check licensed modules
                check_modules "$WEBBOX_MODULES"

                update_config "$@"

                if [ "$WEBBOX_CLEAR_CACHE" = "yes" ]; then
                        webbox_note "WEBBOX_CLEAR_CACHE set. Clearing dev and prod cache on startup..."
                        rm -rf /srv/app/app/cache/dev /srv/app/app/cache/prod
                fi
                chown nobody:nobody /srv/app/app/cache /srv/app/app/logs /srv/app/web/uploads
                mkdir -p /var/log/php81
                mkdir -p /var/log/caddy/ /var/log/crond /var/log/custom_crond /var/log/php_fpm /var/log/sshd /var/log/webbox_websocket
        fi
        exec "$@"
}

# If we are sourced from elsewhere, don't perform any further actions
if ! _is_sourced; then
        _main "$@"
fi
