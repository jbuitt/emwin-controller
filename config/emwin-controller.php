<?php

return [

    'npemwind_cmd' => env('NPEMWIND_CMD', '/usr/local/sbin/npemwind -F'),

    'enabled-pan-plugins' => env('ENABLED_PAN_PLUGINS', ''),

    'emwin' => [
        'servers' => env('EMWIN_SERVERS', 'emwin.ewarn.org:2211'),
        'archivedir' => env('EMWIN_ARCHIVE_DIR', 'app/public/products/emwin'),
        'keep_logs_days' => env('EMWIN_KEEP_LOGS_DAYS', 7),
        'keep_products_days' => env('EMWIN_KEEP_PRODUCTS_DAYS', 7),
        'pan_run' => env('EMWIN_PAN_RUN', env('EMWIN_BASE_DIR', '/var/www/html') . '/scripts/pan_run.sh'),
        'file_save_regex' => env('EMWIN_FILE_SAVE_REGEX', '.*'),
        'autostart' => env('EMWIN_NPEMWIN_AUTOSTART', 0),
    ],

];
