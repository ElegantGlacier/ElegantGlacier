<?php

// Autoload Mockery
require_once __DIR__ . '/../vendor/autoload.php';

use Mockery as m;

// Register Mockery's auto-cleaning at the end of each test
afterEach(function () {
    m::close();
});

// This can be used for additional global setup if needed
