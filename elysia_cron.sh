#!/bin/bash
DRUSH='/usr/local/bin/drush'
cd /var/www/html
$DRUSH recommender-cron
$DRUSH customize-call
$DRUSH recommender-run