<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('html_escape')) {
    /**
     * Escape HTML entities in a string or array recursively.
     * Compatible with CodeIgniter 3 html_escape.
     *
     * @param  mixed  $var
     * @param  bool  $double_encode
     * @return mixed
     */
    function html_escape($var, $double_encode = true)
    {
        if (is_array($var)) {
            return array_map(function ($value) use ($double_encode) {
                return html_escape($value, $double_encode);
            }, $var);
        }

        return e($var, $double_encode);
    }
}

if (!function_exists('log_message')) {
    /**
     * Log messages using Laravel's Log system.
     * Compatible with CodeIgniter 3 log_message.
     *
     * @param  string  $level
     * @param  string  $message
     * @return void
     */
    function log_message($level, $message)
    {
        $level = strtolower($level);
        $logger = \Illuminate\Support\Facades\Log::driver();

        if ($level === 'error') {
            $logger->error($message);
        } elseif ($level === 'debug') {
            $logger->debug($message);
        } else {
            $logger->info($message);
        }
    }
}

if (!function_exists('hex_to_rgb')) {
    /**
     * Mengubah kode warna HEX ke format deret angka RGB (misal: #293681 -> 41, 54, 129).
     *
     * @param  string  $hex
     * @return string
     */
    function hex_to_rgb($hex)
    {
        // Hilangkan simbol # jika ada
        $hex = str_replace("#", "", $hex);
        
        // Cek panjang karakter hex
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else if (strlen($hex) == 6) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        } else {
            return '0, 0, 0';
        }
        
        return "$r, $g, $b";
    }
}

