<?php
// filepath: app/Helpers/time_helper.php

if (!function_exists('time_ago')) {
    /**
     * Convert timestamp to human readable time ago
     * 
     * @param string $datetime
     * @return string
     */
    function time_ago($datetime)
    {
        $timestamp = strtotime($datetime);
        $difference = time() - $timestamp;
        
        $periods = [
            'detik' => 1,
            'menit' => 60,
            'jam' => 3600,
            'hari' => 86400,
            'minggu' => 604800,
            'bulan' => 2592000,
            'tahun' => 31536000
        ];
        
        foreach ($periods as $key => $value) {
            if ($difference < $value) {
                break;
            }
            $time = $key;
            $number = floor($difference / $value);
        }
        
        if (!isset($number)) {
            $number = 0;
            $time = 'detik';
        }
        
        return $number . ' ' . $time . ' yang lalu';
    }
}

if (!function_exists('format_duration')) {
    /**
     * Format duration in seconds to human readable format
     * 
     * @param int $seconds
     * @return string
     */
    function format_duration($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        
        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
        } else {
            return sprintf('%02d:%02d', $minutes, $secs);
        }
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date to Indonesian format
     * 
     * @param string $date
     * @param string $format
     * @return string
     */
    function format_date($date, $format = 'd M Y')
    {
        $months = [
            'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar',
            'Apr' => 'Apr', 'May' => 'Mei', 'Jun' => 'Jun',
            'Jul' => 'Jul', 'Aug' => 'Agt', 'Sep' => 'Sep',
            'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'
        ];
        
        $formatted = date($format, strtotime($date));
        
        return str_replace(array_keys($months), array_values($months), $formatted);
    }
}

if (!function_exists('format_number')) {
    /**
     * Format number with Indonesian format
     * 
     * @param float $number
     * @param int $decimals
     * @return string
     */
    function format_number($number, $decimals = 2)
    {
        return number_format($number, $decimals, ',', '.');
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format currency to Indonesian Rupiah
     * 
     * @param float $amount
     * @return string
     */
    function format_currency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}