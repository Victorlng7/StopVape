#!/usr/bin/env bash

set -u

PROJECT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"
PHP_PID=""
VUE_PID=""

cleanup() {
    trap - EXIT INT TERM
    printf '\nArrêt des serveurs...\n'

    if [[ -n "$PHP_PID" ]] && kill -0 "$PHP_PID" 2>/dev/null; then
        kill -- -"$PHP_PID" 2>/dev/null || kill "$PHP_PID" 2>/dev/null || true
    fi

    if [[ -n "$VUE_PID" ]] && kill -0 "$VUE_PID" 2>/dev/null; then
        kill -- -"$VUE_PID" 2>/dev/null || kill "$VUE_PID" 2>/dev/null || true
    fi

    wait 2>/dev/null || true
    printf 'Serveurs arrêtés. MariaDB reste active.\n'
}

trap cleanup EXIT INT TERM

sudo systemctl start mariadb

cd "$PROJECT_DIR/api"
setsid php -S localhost:8000 &
PHP_PID=$!

cd "$PROJECT_DIR"
setsid bun dev &
VUE_PID=$!

printf 'API PHP : http://localhost:8000\n'
printf 'Interface Vue : http://localhost:5173\n'
printf 'Appuyez sur Ctrl+C pour arrêter les deux serveurs.\n'

wait