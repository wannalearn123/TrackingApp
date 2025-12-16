<?php
// filepath: app/Controllers/Test.php

namespace App\Controllers;

class Test extends BaseController
{
    public function testHelpers()
    {
        // Test time_ago
        echo time_ago('2024-12-15 10:00:00') . '<br>';
        // Output: "1 hari yang lalu"
        
        // Test format_duration
        echo format_duration(3665) . '<br>';
        // Output: "01:01:05"
        
        // Test format_date
        echo format_date('2024-12-16') . '<br>';
        // Output: "16 Des 2024"
        
        // Test format_number
        echo format_number(1234.567, 2) . '<br>';
        // Output: "1.234,57"
    }
}