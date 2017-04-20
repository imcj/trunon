<?php
namespace App\Core;

use App\Model\Process;

class SupervisordStateTransfer
{
    public function toSupervisordState($enum)
    {
    }

    public function toProcessEnum($state)
    {
        $enum = null;
        switch ($state) {
            case 0:
                $enum = Process::STOPPED;
                break;
            case 10:
                $enum = Process::STARTING;
                break;
            case 20:
                $enum = Process::RUNNING;
                break;
            case 30:
                $enum = Process::BACKOFF;
                break;
            case 40:
                $enum = Process::STOPPING;
                break;
            case 100:
                $enum = Process::EXITED;
                break;
            case 200:
                $enum = Process::FATAL;
                break;
            case 1000:
                $enum = Process::UNKNOW;
                break;
        }

        if (null == $enum)
            throw new Exception("Enum is not allow null.");
        return $enum;
    }
}