# Recommemder system
A recommender system integrated with ubercart and drupal7

After installation (import database and config the setting.php file to connect to database), follow these steps to compute recommendations:

1. Create elysia_cron.sh file to execute some drush command line for recommendations
2. Add line below into crontab via crontab -e
*/5 * * * * /var/www/html/elysia_cron.sh > logfile 2>&1