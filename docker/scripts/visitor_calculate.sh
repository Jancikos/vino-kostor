#!/bin/bash

set -eo pipefail
shopt -s nullglob

FLAG="visitor_calculate"
ADDRESS="http://127.0.0.1/visitor/api/calculate"

source "$(dirname "$0")/util/webapi_call.sh"

webapi_call "$FLAG" "$ADDRESS"
