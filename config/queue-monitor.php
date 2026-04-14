<?php

use romanzipp\QueueMonitor\Models\Monitor;

return [
    /*
     * Set the table to be used for monitoring data.
     */
    'table' => 'queue_monitor',
    'connection' => null,

    /*
     * Set the model used for monitoring.
     * If using a custom model, be sure to implement the
     *   romanzipp\QueueMonitor\Models\Contracts\MonitorContract
     * interface or extend the base model.
     */
    'model' => Monitor::class,

    // Determined if the queued jobs should be monitored
    'monitor_queued_jobs' => true,

    // Max age of monitor records in days
    'keep_monitor_days' => 30,

    // Progress update interval
    'progress_update_interval' => 5,

    /*
     * Specify the max character length to use for storing exception backtraces.
     */
    'db_max_length_exception' => 4294967295,
    'db_max_length_exception_message' => 65535,

    /*
     * The optional UI settings.
     */
    'ui' => [
        // Enable the UI
        'enabled' => true,

        // Accepts route group configuration
        'route' => [
            'prefix' => 'jobs',
            'middleware' => ['web', 'auth'],
        ],
        /*
         * Set the monitored jobs count to be displayed per page.
         */
        'per_page' => 20,

        /*
         *  Show custom data stored on model
         */
        'show_custom_data' => false,

        /**
         * Allow the deletion of single monitor items.
         */
        'allow_deletion' => true,

        /**
         * Allow purging all monitor entries.
         */
        'allow_purge' => true,

        'show_metrics' => true,

        /**
         * Time frame used to calculate metrics values (in days).
         */
        'metrics_time_frame' => 14,

        /**
         * The interval before refreshing the dashboard (in seconds).
         */
        'refresh_interval' => 10,
    ],
];
