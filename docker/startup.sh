#!/bin/bash

set -eo pipefail
shopt -s nullglob

WEBBOX_FOLDER=/srv/app

# logging functions
webbox_log() {
        local type="$1"; shift
        # accept argument string or stdin
        local text="$*"; if [ "$#" -eq 0 ]; then text="$(cat)"; fi
        local dt; dt="$(date --rfc-3339=seconds)"
        printf '%s [%s] [Startup]: %s\n' "$dt" "$type" "$text"
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

# Generate ssh host keys if they don't exist
/usr/bin/ssh-keygen -A

# turn on bash's job control
set -m

# Start the primary process and put it in the background
/usr/bin/supervisord -n &
  
# Start the helper process
while netstat -lnt | awk '$4 ~ /:80$/ {exit 1}'; do sleep 10; done

webbox_note "Web server started"

# DOCKER TODO - odkomentovat po rozbehani celeho staccku
# webbox_note "Running database update..."
# php $WEBBOX_FOLDER/vendor/propel/propel/bin/propel.php migrate --config-dir $WEBBOX_FOLDER/config/propel
# webbox_note "Database update finished"
  
# the my_helper_process might need to know how to wait on the
# primary process to start before it does its work and returns

CONFIG_FOLDER=$WEBBOX_FOLDER/config
 
CUSTOM_CRONTAB_PATH="/opt/customized/crontab"
if test -f "$CUSTOM_CRONTAB_PATH"; then
        webbox_note "Custom crontab exists. Starting custom cron..."
	mkdir -p /opt/custom-crontabs
	echo "SHELL=/bin/sh" > /opt/custom-crontabs/nobody
	cat /opt/customized/crontab >> /opt/custom-crontabs/nobody
        /usr/bin/supervisorctl start custom_crond || true
fi

# now we bring the primary process back into the foreground
# and leave it there
fg %1
