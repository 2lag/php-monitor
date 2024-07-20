<!DOCTYPE html>
<html>
<head>
  <title>stats</title>
  <script>
    //function refresh_page( ) { location.reload( ); }
    //setInterval( refresh_page, 5000 );
  </script>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <?php
    require_once('normalize_degrees.php');
    require_once('resources/memory.php');
    require_once('resources/uptime.php');
    require_once('resources/disk.php');
    require_once('resources/cpu.php');

    $memory_arr = get_server_memory( false );
    $memory = get_server_memory( true );
    $disk = get_all_disk_space( );
    $cpu = get_cpu_usage( );
  ?>

  <!-- add https://stackoverflow.com/questions/14222138/css-progress-circle -->
   <!-- + logging of values every 10 minutes, starting a new file daily -->

  <h2>Resources</h2>

  <div>
    <div class="cpu">
      <div class="dial" style="--progress: <?php echo normalize_degrees( $cpu, true ); ?>deg;" data-progress="<?php echo $cpu; ?>"></div>
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
      <?php echo get_uptime(); ?>
      <label>Uptime</label>
    </div>
  </div>
</body>
</html>