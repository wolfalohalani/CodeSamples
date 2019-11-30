<?php

namespace Drupal\reseller_entity\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\examples\Utility\DescriptionTemplateTrait;

/**
 * Controller routines for page routes.
 */
class ResellerEntityController extends ControllerBase {


  /**
   * {@inheritdoc}
   */
  protected function getModuleName() {
    return 'reseller_entity';
  }

  /**
   * wheretobuy - page handler for the "Where To Buy" page
   */

  public function wheretobuy() {

    $query = null;
    $markup = "";
    $state = "";
    $state = $_GET['state'];

    $title = $this->t("Our Resellers");

    //if there is no state specified show them everything
    if (strlen($state) < 1) {
      $query = \Drupal::entityQuery('reseller_entity_reseller')
        ->sort('state');
    } else {
      $query = \Drupal::entityQuery('reseller_entity_reseller')
        ->condition('state', $state);
      $title .= " in " . $state;
    }

    $cids = $query->execute();
    $oldstate = $state;
    foreach ( $cids as $cid) {
      $reseller = \Drupal::entityTypeManager()
          ->getStorage('reseller_entity_reseller')
          ->load($cid);
      $state = $reseller->getState();

      if ( strcmp($state, $oldstate) !== 0) {
        $resellerText .= "<h2>" . getStateName($state) . "</h2><p>";
        $oldstate = $state;
      }
      $view_builder = \Drupal::entityManager()->getViewBuilder('reseller_entity_reseller');
      $markup = $view_builder->view($reseller, "wheretobuy");
      $resellerText .= $markup["#markup"];
    }

    return [
      '#title' => $title,
      '#markup' => '<p>' . $resellerText . '</p>',
      ];
    }
	
//end of the class
}
  
  
  
      