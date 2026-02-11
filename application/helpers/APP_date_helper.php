<?php

if (!function_exists('timezone_list')) {
    function timezone_list()
    {
        $timezones = array();
        foreach (DateTimeZone::listIdentifiers() as $timezone) {
            $dt = new \Carbon\Carbon('now');
            $tz = new DateTimeZone($timezone);
            $dt->setTimezone($tz);
            $offset = $dt->getOffset();
            $offset_string = format_timezone_offset($offset, true);
            if (!isset($timezones[$offset_string])) {
                $timezones[$offset_string] = [];
            }
            $dateformat = $dt->format('d m Y H:i:s');
            $timezones['UTC ' . $offset_string . ' - ' . $dateformat][$timezone] = $timezone . ' - ' . $dateformat;
        }
        ksort($timezones);
        return $timezones;
    }

}

if (!function_exists('format_timezone_offset')) {
    function format_timezone_offset($tz_offset, $show_null = false)
    {
        $sign = ($tz_offset < 0) ? '-' : '+';
        $time_offset = abs($tz_offset);
        if ($time_offset == 0 && $show_null == false) {
            return '';
        }
        $offset_seconds = $time_offset % 3600;
        $offset_minutes = $offset_seconds / 60;
        $offset_hours   = ($time_offset - $offset_seconds) / 3600;
        $offset_string  = sprintf("%s%02d:%02d", $sign, $offset_hours, $offset_minutes);
        return $offset_string;
    }
}

if (!function_exists('date_format_list')) {
    function date_format_list()
    {
        $carbon = new \Carbon\Carbon('now');
        $return = [
            'MMMM D, YYYY, hh:mm A' => user_date_format_localized($carbon, 'MMMM D, YYYY, hh:mm A'),
            'DD MMMM YYYY, HH:mm'     => user_date_format_localized($carbon, 'DD MMMM YYYY, HH :mm'),
            'DD MMM YYYY, HH:mm'     => user_date_format_localized($carbon, 'DD MMM YYYY, HH :mm'),
            'D. MMM YYYY HH:mm'     => user_date_format_localized($carbon, 'D. MMM YYYY HH:mm')
        ];
        return $return;
    }
}

if (!function_exists('get_date_format_from_datetime_format')) {
    function get_date_format_from_datetime_format($value)
    {
        $format = [
            'MMMM D, YYYY, hh:mm A' => 'MMMM D, YYYY',
            'DD MMMM YYYY, HH:mm' => 'DD MMMM YYYY',
            'DD MMM YYYY, HH:mm' => 'DD MMM YYYY',
            'D. MMM YYYY HH:mm' => 'D. MMM YYYY',
        ];
        return $format[$value] ?? null;
    }
}

if (!function_exists('get_input_date_format')) {
    function get_input_date_format()
    {
        return 'Y-m-d';
    }
}

if (!function_exists('is_valid_input_date')) {
    function is_valid_input_date($value)
    {
        return (boolean) preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $value);
    }
}

if (!function_exists('get_input_date')) {
    function get_input_date($value, $round_half_up = false)
    {
        if (!is_valid_input_date($value)) {
            return false;
        }
        $date =  Carbon\Carbon::createFromFormat(get_input_date_format(), $value, get_user_timezone());
        if ($round_half_up) {
            $date->hour = 24;
            $date->minute = 59;
            $date->second = 59;
        } else {
            $date->hour = 0;
            $date->minute = 0;
            $date->second = 0;
        }

        if (!$date->local) {
            $date->setTimezone(\date_default_timezone_get());
        }
        return $date;
    }
}

if (!function_exists('get_input_datetime_format')) {
    function get_input_datetime_format()
    {
        return 'Y-m-d H:i';
    }
}

if (!function_exists('get_input_datetime_FR_format')) {
    function get_input_datetime_FR_format()
    {
        return 'd/m/Y H:i';
    }
}

if (!function_exists('is_valid_input_datetime')) {
    function is_valid_input_datetime($value)
    {
        return (boolean) preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])[\ ]([0-9]{2})[\:]([0-9]{2})?$/", $value);
    }
}
if (!function_exists('is_valid_input_FR_datetime')) {
    function is_valid_input_FR_datetime($value)
    {
        return (boolean) preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}[\ ]([0-9]{2})[\:]([0-9]{2})?$/", $value);
    }
}

if (!function_exists('get_input_datetime')) {
    function get_input_datetime($value)
    {
        if (!is_valid_input_datetime($value)) {
            return false;
        }
        $date =  Carbon\Carbon::createFromFormat(get_input_datetime_format(), $value, get_user_timezone());

        if (!$date->local) {
            $date->setTimezone(\date_default_timezone_get());
        }
        return $date;
    }
}

if (!function_exists('get_FR_input_datetime')) {
    function get_FR_input_datetime($value)
    {
        if (!is_valid_input_FR_datetime($value)) {
            return false;
        }
        $date =  Carbon\Carbon::createFromFormat(get_input_datetime_FR_format(), $value, get_user_timezone());

        if (!$date->local) {
            $date->setTimezone(\date_default_timezone_get());
        }
        return $date;
    }
}

if (!function_exists('get_user_timezone')) {
    function get_user_timezone()
    {
        $user = app()->authenticationService->user();
        return ($user && $user->timezone ? $user->timezone : date_default_timezone_get());
    }
}

if (!function_exists('get_user_date_format')) {
    function get_user_date_format()
    {
        $user = app()->authenticationService->user();
        return ($user && $user->date_format? $user->date_format : 'DD MMMM YYYY');
    }
}

if (!function_exists('get_user_datetime_format')) {
    function get_user_datetime_format()
    {
        $user = app()->authenticationService->user();
        return ($user && $user->datetime_format? $user->datetime_format : 'DD MMMM YYYY, HH:mm');
    }
}

if (!function_exists('date_format_localized')) {
    function user_date_format_localized(Carbon\Carbon $date, $format, $timezone = false)
    {
        $date->locale(config_item('language.key'));
        $timezone = ($timezone?: get_user_timezone());
        setlocale(LC_TIME, config_item('language.local'));
        $return = $date->setTimezone($timezone)->isoFormat($format);
        setlocale(LC_TIME, 0);
        return $return;
    }
}

if (!function_exists('user_date_format')) {
    function user_date_format(\Carbon\Carbon $date, $withHours = false)
    {
        if ($withHours) {
            $format = get_user_datetime_format();
        } else {
            $format = get_user_date_format();
        }
        $return = user_date_format_localized($date, $format);
        return $return;
    }
}

// return the date with hours, minutes and seconds
if (!function_exists('date_format_complete')) {
    function date_format_complete(\Carbon\Carbon $date)
    {
        $format = 'DD MMMM YYYY, HH:mm:ss';
        $return = user_date_format_localized($date, $format);
        return $return;
    }
}

// return false if date_before > date_after
if (!function_exists('compare_before_after_date')) {
    function is_date_before($date_before, $date_after)
    {
        $date_b = new \Carbon\Carbon($date_before);
        $date_a = new \Carbon\Carbon($date_after);
        return !$date_b->gt($date_a); // gt : Determines if the instance is greater (after) than another
    }
}

