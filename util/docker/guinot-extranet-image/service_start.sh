#!/bin/sh

# Start Apache
service apache2 start

# Start Cron
service cron start

# Start EXIM
service exim4 start
