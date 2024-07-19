<!DOCTYPE html>
<html>
<head>
  <title>stats</title>
  <script>
    function refresh_page( ) { location.reload( ); }
    setInterval( refresh_page, 5000 );
  </script>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <?php
    require_once('resources/memory.php');
    require_once('resources/uptime.php');
    require_once('resources/disk.php');
    require_once('resources/cpu.php');

    $memory = get_server_memory( false );
    $disk = get_all_disk_space( );
  ?>

  <div>
    <div class="cpu">
      <progress value="<?php echo get_cpu_uasge(); ?>" max="100"></progress>
      <label>
        CPU Usage
        ( <?php echo get_cpu_uasge(); ?> % )
      </label>
    </div>

    <div class="memory">
      <progress value="<?php echo $memory["total"] - $memory["free"]; ?>" max="<?php echo $memory["total"]; ?>"></progress>
      <label>Memory Usage</label>
      <p>
        <?php
          echo sprintf( "%s / %s ( %s %% )",
            pretty_print_file_size( $memory["total"] - $memory["free"] ),
            pretty_print_file_size( $memory["total"]),
            round( get_server_memory( true ), 2 )
          );
        ?>
      </p>
    </div>

    <?php foreach ( $disk as $drive => $data ) : ?>
      <div class="disk">
        <progress value="<?php echo $data['percentage']; ?>" max="100"></progress>
        <label>
          Disk Usage ( <?php echo $drive; ?> )
        </label>
        <p>
          <?php
            echo sprintf( "%s / %s ( %s %% )",
              pretty_print_file_size( $data['used'] ),
              pretty_print_file_size( $data['total']),
              round( $data['percentage'], 2 )
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