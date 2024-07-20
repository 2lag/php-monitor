<?php
function log_to_file( $cpu, $memory, $uptime ) {
  $log_file = './' . date( 'Y-m-d' ) . '.monitor';
  $log_data = sprintf(
    "[%s] CPU: %s%%, Memory: %sMB, Uptime: %s\n",
    date( 'H:i:s' ), $cpu, $memory, $uptime
  );
  file_put_contents( $log_file, $log_data, FILE_APPEND );
}