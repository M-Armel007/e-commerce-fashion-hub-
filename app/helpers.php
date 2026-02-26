<?php

if (!function_exists('active_filter')) {
    function active_filter($type, $value) {
        return request($type) == $value ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300';
    }
}