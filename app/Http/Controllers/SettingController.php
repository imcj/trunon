<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AppNotification;

class SettingController extends Controller
{
    public function index()
    {
        return view("setting/profile");
    }
}