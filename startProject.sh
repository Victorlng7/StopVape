sudo systemctl start mariadb

cd api
php -S localhost:8000
PID_PHP=$!
cd ..

bun dev
PID_VUE=$!

cleanup() {
    sudo kill -9 $PID_PHP $PID_VUE
    exit
}

trap cleanup SIGINT

wait