<?php
//
// Recommended way to include parent theme styles.
//  (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
//
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

//
// remove the Add to Cart and Qty controls
remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);

//
// figure out the Manufacturer from the Product Manufacturer attribute
function gci_action_woocommerce_item_manufacturer () {
  $desired_att = 'Manufacturer';

  global $product;
  $attributes = $product->get_attributes();

  if ( ! $attributes ) {
      return;
  }

  $out = '';

  foreach ( $attributes as $attribute ) {
      $name = $attribute->get_name();
      if ( $attribute->is_taxonomy() ) {

          // sanitize the desired attribute into a taxonomy slug
          $tax_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $desired_att)));

          // if this is desired att, get value and label
          if ( $name == 'pa_' . $tax_slug ) {

              $terms = wp_get_post_terms( $product->get_id(), $name, 'all' );
              // get the taxonomy
              $tax = $terms[0]->taxonomy;
              // get the tax object
              $tax_object = get_taxonomy( $tax );
              // get tax label
              if ( isset ( $tax_object->labels->singular_name ) ) {
                  $tax_label = $tax_object->labels->singular_name;
              } elseif ( isset( $tax_object->label ) ) {
                  $tax_label = $tax_object->label;
                  // Trim label prefix since WC 3.0
                  if ( 0 === strpos( $tax_label, 'Product ' ) ) {
                     $tax_label = substr( $tax_label, 8 );
                  }
              }

              foreach ( $terms as $term ) {
                  $out .= '<h3>(';
                  //$out .= $tax_label . ': ';
                  $out .= $term->name;
                  $out .= ')</h3>';
              }

          } // our desired att

      } else {

          // for atts which are NOT registered as taxonomies

          // if this is desired att, get value and label
          if ( $name == $desired_att ) {
              //$out .= $name . ': ';
              $out .= '<h3>(';
              $out .= esc_html( implode( ', ', $attribute->get_options() ) );
              $out .= ')</h3>';

          }
      }


  }
  echo $out;
}
add_action ('woocommerce_single_product_summary', 'gci_action_woocommerce_item_manufacturer', 5);

// Display 12 Woocommerce products per page.
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

