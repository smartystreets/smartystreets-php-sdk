#!/bin/bash

# Start echo server
php -S localhost:8080 tests/EchoServer.php > /dev/null 2>&1 &
SERVER_PID=$!

# Wait a second for the server to be ready
sleep 1

# Run PHPUnit
phpunit --display-phpunit-deprecations --group integration tests/

# Kill the echo server
kill $SERVER_PID