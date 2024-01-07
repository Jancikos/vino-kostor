#!/bin/bash

set -eo pipefail
shopt -s nullglob

FLAG="system_import_users"
ADDRESS="http://127.0.0.1/system/api/connectors/importUsers"

source "$(dirname "$0")/util/webapi_call.sh"

webapi_call "$FLAG" "$ADDRESS"
