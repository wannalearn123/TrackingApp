<?php

if (!function_exists('format_distance')) {
    /**
     * Format distance for display
     * 
     * @param float $distance Distance in km
     * @param int $decimals Number of decimal places
     * @return string Formatted distance
     */
    function format_distance(float $distance, int $decimals = 2): string
    {
        return number_format($distance, $decimals, ',', '.') . ' km';
    }
}

if (!function_exists('format_duration')) {
    /**
     * Format duration from seconds to HH:MM:SS
     * 
     * @param int $seconds Duration in seconds
     * @return string Formatted duration
     */
    function format_duration(int $seconds): string
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

if (!function_exists('format_pace')) {
    /**
     * Format pace (minutes per km)
     * 
     * @param float $pace Pace in minutes per km
     * @return string Formatted pace
     */
    function format_pace(float $pace): string
    {
        $minutes = floor($pace);
        $seconds = round(($pace - $minutes) * 60);
        
        return sprintf('%d:%02d /km', $minutes, $seconds);
    }
}

if (!function_exists('calculate_pace')) {
    /**
     * Calculate pace from duration and distance
     * 
     * @param int $duration Duration in seconds
     * @param float $distance Distance in km
     * @return float Pace in minutes per km
     */
    function calculate_pace(int $duration, float $distance): float
    {
        if ($distance <= 0) {
            return 0;
        }
        
        $durationMinutes = $duration / 60;
        return round($durationMinutes / $distance, 2);
    }
}

if (!function_exists('calculate_calories')) {
    /**
     * Estimate calories burned (rough calculation)
     * Based on average: 1 km = ~60 calories for running
     * 
     * @param float $distance Distance in km
     * @param float $weight Weight in kg (optional, for more accuracy)
     * @return int Estimated calories
     */
    function calculate_calories(float $distance, float $weight = 70): int
    {
        // Formula: calories = distance (km) × weight (kg) × 1.036
        // This is a simplified METs-based calculation
        return round($distance * $weight * 1.036);
    }
}

if (!function_exists('parse_gps_route')) {
    /**
     * Parse GPS route from JSON string
     * 
     * @param string|null $gpsRoute JSON string of coordinates
     * @return array Array of coordinates
     */
    function parse_gps_route(?string $gpsRoute): array
    {
        if (empty($gpsRoute)) {
            return [];
        }
        
        $route = json_decode($gpsRoute, true);
        return is_array($route) ? $route : [];
    }
}

if (!function_exists('encode_gps_route')) {
    /**
     * Encode GPS route to JSON string
     * 
     * @param array $coordinates Array of [lat, lng] coordinates
     * @return string JSON string
     */
    function encode_gps_route(array $coordinates): string
    {
        return json_encode($coordinates);
    }
}

if (!function_exists('calculate_distance_between_points')) {
    /**
     * Calculate distance between two GPS coordinates using Haversine formula
     * 
     * @param float $lat1 Latitude of point 1
     * @param float $lng1 Longitude of point 1
     * @param float $lat2 Latitude of point 2
     * @param float $lng2 Longitude of point 2
     * @return float Distance in kilometers
     */
    function calculate_distance_between_points(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371; // Earth radius in km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return round($earthRadius * $c, 3);
    }
}