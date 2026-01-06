<?php

if (!function_exists('shortEmail')) {   
    function shortEmail(string $email): string
    {
        [$name, $domain] = explode('@', $email);

        if (strlen($name) <= 2) {
            return $name . '***@' . $domain;
        }

        return substr($name, 0, 2)
            . '***'
            . substr($name, -2)
            . '@'
            . $domain;
    }
}