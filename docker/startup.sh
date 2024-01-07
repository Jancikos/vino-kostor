#!/bin/bash

set -eo pipefail
shopt -s nullglob

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
webbox_note "Running database update..."
curl http://localhost:80/system/api/dataUpdate
webbox_note "Database update finished"
  
# the my_helper_process might need to know how to wait on the
# primary process to start before it does its work and returns

CONFIG_FOLDER=/srv/app/app/config
FLAG=webbox_websocket
 
FLAG_FILE_PATH="$CONFIG_FOLDER/flag_$FLAG"
if test -f "$FLAG_FILE_PATH"; then
	FLAG_NO_FILE_PATH="$CONFIG_FOLDER/flag_no_$FLAG"
        if test -f "$FLAG_NO_FILE_PATH"; then
            webbox_error "Please remove the $FLAG_NO_FILE_PATH first. Both flag and noflag are not allowed."
        fi
	webbox_note "Flag $FLAG exists. Starting websocket server..."
	
	/usr/bin/supervisorctl start webbox_websocket || true
fi

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
