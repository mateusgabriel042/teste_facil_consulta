<?php

use Carbon\Carbon;

if (!function_exists("fmtTimestampToDiffForHumans")) {
    /**
     * Format a timestamp to a human-readable difference.
     *
     * @param string $format
     * @param string|null $timestamp
     * @return string|null
     */
    function fmtTimestampToDiffForHumans(string $format, ?string $timestamp = null): ?string
    {
        return is_null($timestamp) 
            ? null 
            : Carbon::createFromFormat($format, $timestamp)->diffForHumans();
    }
}

if (!function_exists("fmtDate")) {
    /**
     * Format a date from one format to another.
     *
     * @param string $format
     * @param string $mask
     * @param string|null $date
     * @return string|null
     */
    function fmtDate(string $format, string $mask, ?string $date = null): ?string
    {
        return is_null($date) 
            ? null 
            : Carbon::createFromFormat($format, $date)->format($mask);
    }
}

if (!function_exists("convertDateToCarbon")) {
    /**
     * Convert a date to a Carbon instance.
     *
     * @param string $format
     * @param string|null $date
     * @return Carbon|null
     */
    function convertDateToCarbon(string $format, ?string $date = null): ?Carbon
    {
        return is_null($date) 
            ? null 
            : Carbon::createFromFormat($format, $date);
    }
}

if (!function_exists("moneyFormat")) {
    /**
     * Format a monetary value in cents to a readable string.
     *
     * @param int|float $cents
     * @param string $location
     * @return string
     */
    function moneyFormat(int|float $cents, string $location = 'pt_BR'): string
    {
        $real = $cents / 100;
        $formatted_value = number_format($real, 2, ",", ".");
        return "R$ " . $formatted_value;
    }
}
