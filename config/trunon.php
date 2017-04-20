<?php

return array(
    'workspace_dir' => env('WORKSPACE_DIR', base_path('supervisord/run')),
    'xmlrpc_host' => env('XMLRPC_HOST', '127.0.0.1'),
    'xmlrpc_port' => env('XMLRPC_PORT', '9001'),
    'xmlrpc_username' => env('XMLRPC_USERNAME'),
    'xmlrpc_password' => env('XMLRPC_PASSWORD')
);