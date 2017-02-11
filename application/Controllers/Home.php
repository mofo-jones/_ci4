<?php

namespace App\Controllers;


class Home extends KiController {

    public function index() {
        return view('welcome_message');
    }

}
