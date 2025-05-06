<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder as BaseSeeder;

class Seeder extends BaseSeeder
{
    protected $command;

    public function __construct()
    {
        $this->command = new class {
            public function info($message)
            {
                echo $message . "\n";
            }
        };
    }
} 