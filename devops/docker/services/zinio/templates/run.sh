#!/bin/bash
set -e

# Apache gets grumpy about PID files pre-existing. More info: https://stackoverflow.com/questions/39803465/why-does-apache2-does-not-remove-pid-file-on-reboot-on-docker-image
rm -f /var/run/apache2/apache2.pid

exec /usr/sbin/apache2ctl -D FOREGROUND