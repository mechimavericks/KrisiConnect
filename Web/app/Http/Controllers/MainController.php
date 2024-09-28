<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function scan_index()
    {
        return view('scan');
    }
    public function iot_index()
    {
        return view('iot');
    }
}
