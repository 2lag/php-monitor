<?php
function normalize_degrees( $percentage, $skipround = false ) {
  if ( $skipround ) {
      return ( $percentage / 100 ) * 360;
  }
  return round( ( $percentage / 100 ) * 360, 2 );
}