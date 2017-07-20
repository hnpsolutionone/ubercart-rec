<?php

/**
 * Drupal customize drush interface.
 * To use this, please install Drush at http://drupal.org/project/drush
 */

/**
 * Implements hook_drush_command().
 */
function customize_drush_command() {
    $items = array();

    $items['customize-call'] = array(
        'description' => 'Call any Drupal/PHP functions and print results as json for further process. All parameters must be encoded in Json.',
        'hidden' => TRUE,
        'examples' => array(
            'drush customize-call' => 'Display node 1 data in json',
        ),
        'bootstrap' => DRUSH_BOOTSTRAP_DRUPAL_FULL,
    );

    return $items;
}

/**
 * Call a Drupal function, where parameters are passed in as json string.
 * Print JSON results.
 */
function drush_customize_call() {
    // Add 3 recommenders application
    $recommenders = array();
    $recommenders[0] = array
    (
        'title' => 'Fivestar Recommender',
        'description' => 'Run recommender on users browsing history using the item-item algorithm. Only works for "node" (or "Content") entity type.',
        'algorithm' => 'item2item',
        'data structure' => array
        (
            'preference' => array
            (
                'type' => 'table',
                'name' => 'fivestar_rec_vote',
            ),

            'item similarity' => array
            (
                'type' => 'table',
                'name' => 'fivestar_rec_similarity',
            ),

            'prediction' => array
            (
                'type' => 'table',
                'name' => 'fivestar_rec_prediction',
            ),

            'item entity type' => 'node',
        ),

        'cron callback' => 'fivestar_rec_process_vote',
        'upkeep callback' => 'fivestar_rec_purge_vote',
        'form callback' => 'recommender_command_form',
        'command' => 'item2item',
        'application' => 'recommender',
    );

    $recommenders[1] = array
    (
        'title' => 'Browsing History Recommender',
        'description' => 'Run recommender on users browsing history using the item-item algorithm.',
        'algorithm' => 'item2item_boolean',
        'data structure' => array
        (
            'preference' => array
            (
                'type' => 'table',
                'name' => 'history_rec_data',
                'user field' => 'euid',
                'item field' => 'nid',
                'score field' => 'score',
                'score type' => 'boolean',
                'timestamp field' => 'updated',
            ),

            'item similarity' => array
            (
                'type' => 'table',
                'name' => 'history_rec_item_similarity',
            ),

            'prediction' => array
            (
                'type' => 'table',
                'name' => 'history_rec_prediction',
            ),

            'item entity type' => 'node',
        ),

        'options' => array
        (
            'prediction skip invalid uid' => 1,
        ),

        'form elements callback' => 'history_rec_extra_options',
        'cron callback' => 'history_rec_update_data',
        'form callback' => 'recommender_command_form',
        'command' => 'item2item_boolean',
        'application' => 'recommender',
    );

    $recommenders[2] = array
    (
        'title' => 'Ubercart Recommender',
        'description' => 'Generate product recommendations based on users purchasing history. See technical details in README.txt.',
        'algorithm' => 'item2item_boolean',
        'data structure' => array
        (
            'preference' => array
            (
                'type' => 'table',
                'name' => 'uc_rec_purchase',
                'score type' => 'boolean',
                'no views' => '1',
            ),

            'item similarity' => array
            (
                'type' => 'table',
                'name' => 'uc_rec_similarity',
            ),

            'prediction' => array
            (
                'type' => 'table',
                'name' => 'uc_rec_prediction',
            ),

            'item entity type' => 'node',
        ),

        'cron callback' => 'uc_rec_cron_callback',
        'upkeep callback' => 'uc_rec_upkeep_callback',
        'form callback' => 'recommender_command_form',
        'command' => 'item2item_boolean',
        'application' => 'recommender',
    );

    foreach($recommenders as $data) {
        $default_options = isset($data['options']) ? $data['options'] : array();
        $input = array(
            'algorithm' => $data['algorithm'],
            'data structure' => recommender_prepare_data_structure($data['data structure']),
            'options' => $default_options + (isset($form_state['values']['options']) ? $form_state['values']['options']: array()),
        );

        if (variable_get('recommender_show_database_option', FALSE) && !empty($form_state['values']['common']['database'])) {
            global $databases;
            list($db_name, $db_target) = explode('-', $form_state['values']['common']['database']);
            $input['database'] = $databases[$db_name][$db_target];
        }

        $command = isset($data['command']) ? $data['command'] : $data['algorithm'];
        $result = computing_create($data['application'], $command, $data['title'], $input);

        if ($result) {
            drupal_set_message(t('Adding new recommender command successfully. Please run "drush recommender-run" or use Java agent program to execute the command.'));
        }
        else {
            drupal_set_message(t('Cannot add new recommender command. Please inform site administrators.'), 'error');
        }
    }
    drush_log("Processed add recommender application tasks.", 'ok');
}