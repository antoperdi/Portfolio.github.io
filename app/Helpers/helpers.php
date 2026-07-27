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
