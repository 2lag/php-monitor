<?php
function get_uptime()
{
    if (stristr(PHP_OS, 'win')) {
        $output = shell_exec('net stats workstation');
        $lines = explode("\n", $output);
        foreach ($lines as $line) {
            if (stripos($line, 'Statistics since') !== false) {
                $uptime = trim(str_replace('Statistics since', '', $line));
                $uptimeDate = DateTime::createFromFormat('m/d/Y g:i:s A', $uptime);
                if ($uptimeDate) {
                    $currentTime = new DateTime();
                    $interval = $currentTime->diff($uptimeDate);
                    return $interval->format('%a days, %h hours, %i minutes, %s seconds');
                }
            }
        }
        return 'unknown';
    } else {
        $uptime = shell_exec("uptime");
        return explode( ' up ', $uptime )[ 1 ]; 
    }
}