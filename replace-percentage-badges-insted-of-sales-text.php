<?php
/*
Plugin Name: Replace Sale Text with percentage
Plugin URI: https://wordpress.org/plugins/replace-sale-text-with-percentage
Description: This plugin will Replace "Sale Text" with percentage on sales product.
Author: Asif Ali
Author URI: http://asifalimca.wordpress.com
Version: 1.1.0
License: GPLv2
*/
add_action( 'woocommerce_sale_flash', 'woocommerce_sale_badge_percentage', 25 );
 
function woocommerce_sale_badge_percentage() {
   global $product;
   if ( ! $product->is_on_sale() ) return;
   if ( $product->is_type( 'simple' ) ) {
      $max_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;
   } elseif ( $product->is_type( 'variable' ) ) {
      $max_percentage = 0;
      foreach ( $product->get_children() as $child_id ) {
         $variation = wc_get_product( $child_id );
         $price = $variation->get_regular_price();
         $sale = $variation->get_sale_price();
         if ( $price != 0 && ! empty( $sale ) ) $percentage = ( $price - $sale ) / $price * 100;
         if ( $percentage > $max_percentage ) {
            $max_percentage = $percentage;
         }
      }
   }
   //if ( $max_percentage > 0 ) echo "<span class='onsale'>" . round($max_percentage) . "% off - Final Sale</span>"; // If you would like to show -40% off then add text after % sign
   if ( $max_percentage > 0 ) echo "<span class='onsale'>" . round($max_percentage) . "% off</span>"; 
}