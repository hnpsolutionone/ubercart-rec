# Recommemder system
A recommender system with ubercart and drupal7

Note: Please create cron job to execute some tasks below for recommender system

*/15 * * * * drush recommender-cron // 1. Run Drupal Cron to feed product purchase history into recommender. (Navigation to http://localhost/ubercart_rec/admin/config/system/computing/recommender and chose "Separately with Drush" option)
*/20 * * * * drush customize-call // 2. Run Drupal Cron to add a computing command.
*/25 * * * * drush recommender-run // 3. Run Drupal Cron to compute recommendations using