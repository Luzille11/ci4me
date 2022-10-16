<?php

namespace App\Controllers;

use Codeigniter\Controllers;
use Throwable;

class Migrate extends BaseController
{
    public function index()
    {
        $migrate = \Config\Services::migrations();

        try {
            $migrate->latest();
        } catch (Throwable $e) {
            // Do something with the error here...
        }
    }
}
