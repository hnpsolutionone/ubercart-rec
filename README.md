# Recommemder system
A recommender system integrated with ubercart and drupal7

After installation (import database and config the setting.php file to connect to database), follow these steps to compute recommendations:

1. Create cron job and add some drush command line to compute recommendations

// 1. Run Drush command line to feed product purchase history into recommender. (Navigation to http://localhost/ubercart_rec/admin/config/system/computing/recommender and chose "Separately with Drush" option)
*/15 * * * * drush recommender-cron

// 2. Run Drush command line to add a computing command.
*/20 * * * * drush customize-call

// 3. Run Drush command line to compute recommendations using
*/25 * * * * drush recommender-run