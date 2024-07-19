<?php
function get_all_disk_space( ) {
  $diskData = array();

  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
      foreach (range('C', 'Z') as $letter) {
          $drive = $letter . ':\\';
          if (is_dir($drive) && disk_total_space($drive) > 0) {
              $totalSpace = disk_total_space($drive);
              $freeSpace = disk_free_space($drive);
              $usedSpace = $totalSpace - $freeSpace;
              $usagePercentage = ($usedSpace / $totalSpace) * 100;
              $diskData[$drive] = array(
                  'total' => $totalSpace,
                  'free' => $freeSpace,
                  'used' => $usedSpace,
                  'percentage' => $usagePercentage
              );
          }
      }
  } else {
      $drive = '/';
      $totalSpace = disk_total_space($drive);
      $freeSpace = disk_free_space($drive);
      $usedSpace = $totalSpace - $freeSpace;
      $usagePercentage = ($usedSpace / $totalSpace) * 100;
      $diskData[$drive] = array(
          'total' => $totalSpace,
          'free' => $freeSpace,
          'used' => $usedSpace,
          'percentage' => $usagePercentage
      );
  }

  return $diskData;
}