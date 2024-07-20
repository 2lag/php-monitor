<!DOCTYPE html>
<html>
<head>
  <title>stats</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <?php
    require_once('normalize_degrees.php');
    require_once('resources/memory.php');
    require_once('resources/uptime.php');
    require_once('resources/disk.php');
    require_once('resources/cpu.php');
    require_once('log.php');

    $memory_arr = get_server_memory( false );
    $memory = get_server_memory( true );
    $disk = get_all_disk_space( );
    $uptime = get_uptime( );
    $cpu = get_cpu_usage( );

    // log to daily file every 10 minutes
    session_start( );
    $time = time( );
    if ( !isset( $_SESSION['last_log_time'] ) ) {
      $_SESSION['last_log_time'] = $time;
    }

    if ( $time - $_SESSION['last_log_time'] >= 600 || $_SESSION['last_log_time'] == $time ) {
      log_to_file( $cpu, $memory, $uptime );
      $_SESSION['last_log_time'] = $time;
    }

    header( "Refresh: 10" );
  ?>

  <h2>Resources</h2>

  <div>
    <div class="cpu">
      <div class="dial" style="--progress: <?php echo normalize_degrees( $cpu, true ); ?>deg;" data-progress="<?php echo round( $cpu, 2 ); ?>"></div>
      <label>CPU Usage</label>
    </div>

    <div class="memory">
      <div class="dial" style="--progress: <?php echo normalize_degrees( $memory ); ?>deg;" data-progress="<?php echo round( $memory, 2 ); ?>"></div>
      <label>Memory Usage</label>
      <p>
        <?php
          echo sprintf( "%s / %s",
            pretty_print_file_size( $memory_arr["total"] - $memory_arr["free"] ),
            pretty_print_file_size( $memory_arr["total"])
          );
        ?>
      </p>
    </div>

    <?php foreach ( $disk as $drive => $data ) : ?>
      <div class="disk">
        <div class="dial" style="--progress: <?php echo normalize_degrees( $data['percentage'] ); ?>deg;" data-progress="<?php echo round( $data['percentage'], 2 ); ?>"></div>
        <label>
          Disk Usage ( <?php echo $drive; ?> )
        </label>
        <p>
          <?php
            echo sprintf( "%s / %s",
              pretty_print_file_size( $data['used'] ),
              pretty_print_file_size( $data['total'])
            );
          ?>
        </p>
      </div>
    <?php endforeach; ?>

    <div class="uptime">
      <?php echo $uptime; ?>
      <label>Uptime</label>
    </div>
  </div>
</body>
</html>