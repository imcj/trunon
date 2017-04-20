<?php
namespace App\Core;

use Supervisor\Api;

class SupervisordRPCFactory
{
    public function create()
    {
        $config = config('trunon');
        $host = $config['xmlrpc_host'];
        $port = $config['xmlrpc_port'];
        $username = $config['xmlrpc_username'];
        $password = $config['xmlrpc_password'];

        return new Api($host, $port, $username, $password);
    }
}