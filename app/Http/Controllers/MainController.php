<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function main()
    {
        $nombre="Santiago";
        $message = $nombre . " Welcome to the main page.";
        return view('main', compact('message'));
    }
}
