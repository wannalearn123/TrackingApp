<?php

namespace App\Libraries;

class BMICalculator
{
    /**
     * Calculate BMI from height (cm) and weight (kg)
     * 
     * @param float $height Height in centimeters
     * @param float $weight Weight in kilograms
     * @return float BMI value
     */
    public static function calculate(float $height, float $weight): float
    {
        if ($height <= 0 || $weight <= 0) {
            throw new \InvalidArgumentException('Height and weight must be greater than 0');
        }
        
        $heightInMeters = $height / 100;
        $bmi = $weight / ($heightInMeters * $heightInMeters);
        
        return round($bmi, 2);
    }

    /**
     * Categorize BMI value
     * 
     * @param float $bmi BMI value
     * @return string Category name
     */
    public static function categorize(float $bmi): string
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

    /**
     * Get BMI category label in Indonesian
     * 
     * @param string $category BMI category
     * @return string Indonesian label
     */
    public static function getCategoryLabel(string $category): string
    {
        $labels = [
            'underweight' => 'Kurus',
            'normal'      => 'Normal',
            'overweight'  => 'Kelebihan Berat Badan',
            'obese'       => 'Obesitas',
        ];
        
        return $labels[$category] ?? 'Tidak Diketahui';
    }

    /**
     * Check if BMI requires alert
     * 
     * @param string $category BMI category
     * @return bool True if alert needed
     */
    public static function requiresAlert(string $category): bool
    {
        return in_array($category, ['overweight', 'obese']);
    }

    /**
     * Get BMI color for UI highlighting
     * 
     * @param string $category BMI category
     * @return string CSS color class
     */
    public static function getCategoryColor(string $category): string
    {
        $colors = [
            'underweight' => 'warning',
            'normal'      => 'success',
            'overweight'  => 'warning',
            'obese'       => 'danger',
        ];
        
        return $colors[$category] ?? 'secondary';
    }

    /**
     * Get ideal weight range based on height
     * 
     * @param float $height Height in centimeters
     * @return array ['min' => float, 'max' => float]
     */
    public static function getIdealWeightRange(float $height): array
    {
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