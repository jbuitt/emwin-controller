<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Email
    |--------------------------------------------------------------------------
    |
    | This value is the email address of the user that should be considered an
    | administrator.
    */
    'admin_email' => env('ADMIN_EMAIL', 'admin@localhost'),

    /*
    |--------------------------------------------------------------------------
    | Download Clients Enabled
    |--------------------------------------------------------------------------
    |
    | This value is a comma-delimited list of EMWIN download clients that 
    | should be enabled. Valid values are:
    |
    | * npemwin
    | * ftp-text
    | * ftp-graphic
    | * http-text
    | * http-graphic
    |
    | Default is 'npemwin,http-graphic'.
    |
    | Note that the npemwin client does not download the full suite of graphics
    | available on EMWIN.
    */
    'download_clients_enabled' => env('DOWNLOAD_CLIENTS_ENABLED', 'npemwin,http-images'),

    /*
    |--------------------------------------------------------------------------
    | Download Clients
    |--------------------------------------------------------------------------
    |
    | This is an array of download client configration values. Its structure
    | should typically not be modified. In most cases, the default values
    | do not need to be overidden.
    |
    */
    'download_clients' => [

        'npemwin' => [
            'client_cmd' => env('NPEMWIND_CMD', '/usr/local/sbin/npemwind -F'),
            'servers' => env('NPEMWIN_CLIENT_SERVERLIST', 'emwin.ewarn.org:2211'),
            'autostart' => env('NPEMWIN_CLIENT_AUTOSTART', false),
        ],
    
        'ftp' => [
            'server_hostname' => env('FTP_CLIENT_HOSTNAME', 'tgftp.nws.noaa.gov'),
            'server_protocol' => 'ftp',
            'server_username' => env('FTP_CLIENT_USERNAME', 'anonymous'),
            'server_password' => env('FTP_CLIENT_PASSWORD', 'user@host.com'),
            'server_passive_mode' => boolval(env('FTP_CLIENT_PASSIVE_FLAG', 'TRUE')),
            'server_products_path' => env('FTP_CLIENT_PRODUCTS_PATH', 'SL.us008001/CU.EMWIN/DF.xt/DC.gsatR/OPS'),
            'text_products_file' => env('FTP_CLIENT_TEXT_PRODUCTS_FILE', 'txtmin02.zip'),
            'graphic_products_file' => env('FTP_CLIENT_GRAPHIC_PRODUCTS_FILE', 'imgmin15.zip'),
            'temp_directory' => env('FTP_CLIENT_TEMP_DIR', 'app/public/temp'),
        ],

        'http' => [
            'server_hostname' => env('HTTP_CLIENT_HOSTNAME', 'tgftp.nws.noaa.gov'),
            'server_protocol' => 'http',
            'server_passive_mode' => 'n/a',
            'server_username' => env('HTTP_CLIENT_USERNAME', ''),
            'server_password' => env('HTTP_CLIENT_PASSWORD', ''),
            'server_products_path' => env('HTTP_CLIENT_PRODUCTS_PATH', 'SL.us008001/CU.EMWIN/DF.xt/DC.gsatR/OPS'),
            'text_products_file' => env('HTTP_CLIENT_TEXT_PRODUCTS_FILE', 'txtmin02.zip'),
            'graphic_products_file' => env('HTTP_CLIENT_GRAPHIC_PRODUCTS_FILE', 'imgmin15.zip'),
            'temp_directory' => env('HTTP_CLIENT_TEMP_DIR', 'app/public/temp'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Archive Directory
    |--------------------------------------------------------------------------
    |
    | This value is the relative base path within the storage/ directory for 
    | where EMWIN products are saved.
    |
    */
    'archive_directory' => env('ARCHIVE_DIR', 'app/public/products/emwin'),

    /*
    |--------------------------------------------------------------------------
    | PAN Run
    |--------------------------------------------------------------------------
    |
    | This value is the full path to the PAN (Product Arrival Notification) 
    | script. It typically does not need to be changed from its default
    | value.
    |
    */
    'pan_run' => env('PAN_RUN', env('BASE_DIR', '/var/www/html') . '/scripts/pan_run.sh'),

    /*
    |--------------------------------------------------------------------------
    | Keep Log Days
    |--------------------------------------------------------------------------
    |
    | This value is the number of days to keep log files. Defaults to 1 week.
    |
    */
    'keep_logs_days' => env('KEEP_LOGS_DAYS', 7),

    /*
    |--------------------------------------------------------------------------
    | Keep Products Days
    |--------------------------------------------------------------------------
    |
    | This value is the number of days to keep EMWIN products. Defaults to 1 week.
    |
    */
    'keep_products_days' => env('KEEP_PRODUCTS_DAYS', 7),

    /*
    |--------------------------------------------------------------------------
    | Text File Save Regex
    |--------------------------------------------------------------------------
    |
    | This value is the regular expression used to determine if the EMWIN
    | product file should be saved. Defaults to saving all products.
    |
    */
    'text_file_save_regex' => env('TEXT_FILE_SAVE_REGEX', '.*'),

    /*
    |--------------------------------------------------------------------------
    | Graphic File Save Regex
    |--------------------------------------------------------------------------
    |
    | This value is the regular expression used to determine if the EMWIN
    | product file should be saved. Defaults to saving all products.
    |
    */
    'graphic_file_save_regex' => env('GRAPHIC_FILE_SAVE_REGEX', '.*'),

    /*
    |--------------------------------------------------------------------------
    | Enabled PAN Plugins
    |--------------------------------------------------------------------------
    |
    | This value is the list of PAN plugins that should be enabled. It is a
    | comma-separated list. Default is no plugins are enabled.
    |
    */
    'enabled_pan_plugins' => env('ENABLED_PAN_PLUGINS', ''),

];
