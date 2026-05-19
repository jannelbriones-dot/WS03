<?php

namespace App\Controllers;

use framework\Database;

class HomeController
{
    protected Database $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');

        $this->db = new Database($config);
    }

    public function index()
    {
        $listings = $this->db
            ->query('SELECT * FROM listings ORDER BY created_at DESC LIMIT 6')
            ->fetchAll();

        loadView('home', [
            'listings' => $listings
        ]);
    }
}