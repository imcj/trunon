<?php
namespace App\Validator;

use App\Model\Process;

class ProcessValidator
{
    public function processIdentifier(
        $attribute,
        $value,
        $parameters,
        $validator)
    {
        $process = Process::where("identifier", $value)->first();
        if (null != $process) {
            return false;
        }
        return true;
    }
}