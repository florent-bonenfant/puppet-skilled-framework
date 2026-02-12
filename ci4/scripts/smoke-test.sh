#!/usr/bin/env bash
set -euo pipefail

BASE_URL="${1:-${BASE_URL:-http://127.0.0.1:8080}}"
TIMEOUT="${TIMEOUT:-15}"
TMP_DIR="${TMP_DIR:-/tmp/ci4-smoke}"
mkdir -p "$TMP_DIR"

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

pass_count=0
fail_count=0

contains_php_fatal() {
  local file="$1"
  if rg -n "(Fatal error|Parse error|Uncaught|Whoops!|CodeIgniter\\\\Debug\\\\Exceptions)" "$file" >/dev/null 2>&1; then
    return 0
  fi
  return 1
}

in_expected_codes() {
  local got="$1"
  local expected_csv="$2"
  IFS=',' read -r -a arr <<< "$expected_csv"
  for c in "${arr[@]}"; do
    if [[ "$got" == "$c" ]]; then
      return 0
    fi
  done
  return 1
}

run_case() {
  local name="$1"
  local method="$2"
  local path="$3"
  local expected="$4"
  local data="${5:-}"

  local url="${BASE_URL%/}/${path#/}"
  local body_file="$TMP_DIR/${name//[^a-zA-Z0-9_-]/_}.body"

  local http_code
  if [[ "$method" == "GET" ]]; then
    http_code=$(curl -sS -L --max-time "$TIMEOUT" -o "$body_file" -w "%{http_code}" "$url" || true)
  else
    http_code=$(curl -sS -L --max-time "$TIMEOUT" -o "$body_file" -w "%{http_code}" -X "$method" -H 'Content-Type: application/x-www-form-urlencoded' --data "$data" "$url" || true)
  fi

  local status="PASS"
  local reason=""

  if ! in_expected_codes "$http_code" "$expected"; then
    status="FAIL"
    reason="HTTP $http_code (expected: $expected)"
  fi

  if contains_php_fatal "$body_file"; then
    status="FAIL"
    if [[ -n "$reason" ]]; then
      reason+=" + "
    fi
    reason+="fatal pattern detected"
  fi

  if [[ "$status" == "PASS" ]]; then
    ((pass_count+=1))
    echo -e "${GREEN}PASS${NC} $name -> $http_code"
  else
    ((fail_count+=1))
    echo -e "${RED}FAIL${NC} $name -> $reason"
    echo -e "${YELLOW}  URL:${NC} $url"
    echo -e "${YELLOW}  Body:${NC} $body_file"
  fi
}

echo "Smoke test base URL: $BASE_URL"

# Backoffice pages: unauthenticated requests often redirect/login; we just prevent 500/fatal.
run_case "backoffice-home" GET "backoffice" "200,302,303,401,403"
run_case "backoffice-customer" GET "backoffice/customer" "200,302,303,401,403"
run_case "backoffice-user" GET "backoffice/user" "200,302,303,401,403"
run_case "backoffice-modules-log" GET "backoffice/modules/log" "200,302,303,401,403"
run_case "backoffice-config-role" GET "backoffice/configuration/role" "200,302,303,401,403"

# Webservices
run_case "ws-auth-login-get" GET "webservice/authentication/login" "200,302,303,400,401,403,404,405,422"
run_case "ws-auth-login-post" POST "webservice/authentication/login" "200,400,401,403,404,405,422" "username=smoke%40test.local&password=wrong"
run_case "ws-notification" GET "webservice/notification" "200,400,401,403,404,405,422"
run_case "ws-module" GET "webservice/module" "200,400,401,403,404,405,422"

echo
if [[ "$fail_count" -eq 0 ]]; then
  echo -e "${GREEN}Smoke tests OK${NC} ($pass_count passed)"
  exit 0
fi

echo -e "${RED}Smoke tests FAILED${NC} ($fail_count failed, $pass_count passed)"
exit 1
