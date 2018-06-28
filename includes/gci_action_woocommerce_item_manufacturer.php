<?php

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
