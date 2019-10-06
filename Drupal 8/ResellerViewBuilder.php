<?php

namespace Drupal\reseller_entity\Entity\Controller;

use Drupal\Core\Entity\EntityViewBuilder;
use Drupal\Component\Utility\Html;

/**
 * Provides a Reseller view builder.
 */
class ResellerViewBuilder extends EntityViewBuilder {

  /**
   * {@inheritdoc}
   *
   * 

   */
  public function view($reseller, $view_mode = 'full', $langcode = NULL) {

    if (strcmp($view_mode, "wheretobuy") === 0) {

      $items = array();

      $items['name']    = $reseller->getName();
      $items['address'] = $reseller->getAddress();
      $items['city']    = $reseller->getCity();
      $items['state']   = $reseller->getState();
      $items['zip']     = $reseller->getZip();
      $items['phone']   = $reseller->getPhone();
      $items['website'] = $reseller->getWebsite();
      $items['hours']   = $reseller->getHours();
    
      $items_array = array(
       '#theme' => 'reseller',
       '#items' => $items
      );

     $output = render($items_array);

      return [
        '#markup' => '<p>' . $output . '</p>',
        ];
    }
  }

}

