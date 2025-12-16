<?php

if (!function_exists('calculate_bmi')) {
    /**
     * Calculate BMI from height and weight
     * 
     * @param float $height Height in cm
     * @param float $weight Weight in kg
     * @return float BMI value
     */
    function calculate_bmi(float $height, float $weight): float
    {
        if ($height <= 0 || $weight <= 0) {
            return 0;
        }
        
        $heightInMeters = $height / 100;
        return round($weight / ($heightInMeters * $heightInMeters), 2);
    }
}

if (!function_exists('get_bmi_category')) {
    /**
     * Get BMI category
     * 
     * @param float $bmi BMI value
     * @return string Category
     */
    function get_bmi_category(float $bmi): string
    {
        if ($bmi < 18.5) {
            return 'underweight';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            return 'normal';
        } elseif ($bmi >= 25 && $bmi < 30) {
            return 'overweight';
        } else {
            return 'obese';
        }
    }
}

if (!function_exists('get_bmi_label')) {
    /**
     * Get BMI category label in Indonesian
     * 
     * @param string $category BMI category
     * @return string Label
     */
    function get_bmi_label(string $category): string
    {
        $labels = [
            'underweight' => 'Kurus',
            'normal'      => 'Normal',
            'overweight'  => 'Kelebihan Berat Badan',
            'obese'       => 'Obesitas',
        ];
        
        return $labels[$category] ?? 'Tidak Diketahui';
    }
}

if (!function_exists('get_bmi_color')) {
    /**
     * Get Bootstrap color class for BMI category
     * 
     * @param string $category BMI category
     * @return string Bootstrap color class
     */
    function get_bmi_color(string $category): string
    {
        $colors = [
            'underweight' => 'warning',
            'normal'      => 'success',
            'overweight'  => 'warning',
            'obese'       => 'danger',
        ];
        
        return $colors[$category] ?? 'secondary';
    }
}

if (!function_exists('get_ideal_weight_range')) {
    /**
     * Get ideal weight range based on height
     * 
     * @param float $height Height in cm
     * @return array ['min' => float, 'max' => float]
     */
    function get_ideal_weight_range(float $height): array
    {
        if ($height <= 0) {
            return ['min' => 0, 'max' => 0];
        }
        
        $heightInMeters = $height / 100;
        
        // BMI 18.5 - 24.9 is normal range
        $minWeight = 18.5 * ($heightInMeters * $heightInMeters);
        $maxWeight = 24.9 * ($heightInMeters * $heightInMeters);
        
        return [
            'min' => round($minWeight, 1),
            'max' => round($maxWeight, 1),
        ];
    }
}