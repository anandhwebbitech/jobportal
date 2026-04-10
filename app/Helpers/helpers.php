<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::where('key', $key)->value('value') ?? $default;
    }

}

function getBannerIcon($feature)
{
    return match($feature) {
        'image_banner' => 'fa-image',
        'multi_position' => 'fa-list-check',
        'prime_placement' => 'fa-eye',
        'quick_activation' => 'fa-clock',
        'flat_rate' => 'fa-indian-rupee-sign',
        default => 'fa-circle-check'
    };
}

function formatBannerFeature($feature)
{
    return match($feature) {
        'image_banner' => 'Image Banner',
        'multi_position' => 'Multi-Position',
        'prime_placement' => 'Prime Placement',
        'quick_activation' => 'Quick Activation',
        'flat_rate' => 'Flat Rate',
        default => ucwords(str_replace('_', ' ', $feature))
    };
}

function getBannerDescription($feature, $plan)
{
    return match($feature) {
        'image_banner' => 'Upload PNG, JPG or WEBP — recommended 1200 × 400 px',
        'multi_position' => 'Show multiple job openings in one banner',
        'prime_placement' => 'Top section on ' . $plan->placement,
        'quick_activation' => 'Goes live within 24 hours of payment',
        'flat_rate' => '₹'.$plan->price.' + GST for '.$plan->duration_days.' days',
        default => ''
    };
}