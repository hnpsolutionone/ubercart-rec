Ubercart Recommender
====================


Installation & Configuration
----------------------------

You need to install the Recommender API (7.x-6.x) module and Drupal Computing module before install this module.

After installation, follow these steps to compute recommendations:

  1. Run Drupal Cron to feed product purchase history into recommender.
  2. Go to admin/config/system/computing/list, and click "Ubercart Recommender" to add a computing command.
  3. Compute recommendations using either of the following approaches:
    - Open a command line terminal and run "drush recommender-run".
    - Open a command line terminal and execute the Recommender Java agent.
    - Go to admin/config/system/computing/recommender and click "Run Recommender" (not recommended).
  . You can view the execution results at admin/config/system/computing/records.
  4. Display recommendation results using the default Views.

For more information about how the module works, please read the documentation of Recommender API.


Limitations
-----------

This module is not fully tested yet. Please submit an issue if it doesn't work. Feel free to contact the developer if you need further customization.