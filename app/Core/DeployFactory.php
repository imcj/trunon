<?php
namespace App\Core;


interface DeployFactory
{
    /**
     * Deploy类的工厂类
     *
     * @return Deploy
     */
    function create();
}