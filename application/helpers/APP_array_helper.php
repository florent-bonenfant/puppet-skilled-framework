<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('sort_array_object')) {
    function sort_array_object(array $data, string $key_sort, $sort = 'ASC')
    {
       if ($sort != 'ASC' || $sort != 'DESC') {
            $sort = 'ASC';
       }
       $sort_fct = 'sort_array_object_' . strtolower($sort);
       usort($data, $sort_fct($key_sort));
       return $data;
    }
}

if (!function_exists('sort_array_object_asc')) {
    function sort_array_object_asc($key)
    {
       return function ($a, $b) use ($key) {
            return strnatcmp($a->$key, $b->$key);
       };
    }
}

if (!function_exists('sort_array_object_desc')) {
    function sort_array_object_desc($key)
    {
       return function ($a, $b) use ($key) {
            return !strnatcmp($a->$key, $b->$key);
       };
    }
}
