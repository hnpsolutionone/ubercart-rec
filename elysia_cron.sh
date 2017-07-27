cd /var/www/html/
#1 - Run Drupal Cron to feed product purchase history into recommender. Navigation to http://localhost/ubercart_rec/admin/config/system/computing/recommender and chose Separately with Drush option
drush recommender-cron

#2 - Run Drupal Cron to add a computing command.
drush customize-call

#3 - Run Drupal Cron to compute recommendations using
drush recommender-run