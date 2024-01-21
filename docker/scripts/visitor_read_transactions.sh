#!/bin/bash

set -eo pipefail
shopt -s nullglob

FLAG="visitor_read_transactions"
ADDRESS="http://127.0.0.1/visitor/api/readTransactions"

source "$(dirname "$0")/util/webapi_call.sh"

webapi_call "$FLAG" "$ADDRESS"
