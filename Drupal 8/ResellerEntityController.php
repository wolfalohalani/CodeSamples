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
      $title .= " in " . getStateName($state);
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
 //     $markup = $state . "<P>";
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

// little utility function to get a state name from the two letter code

function getStateName($abbrev) {
  switch ($abbrev) {
    case "AB":
      return t("Alberta");
      break;
    case "AL":
      return t("Alabama");
      break;
    case "AK":
      return t("Alaska");
      break;
    case "AS":
      return t("American Samoa");
      break;
    case "AZ":
      return t("Arizona");
      break;
    case "AR":
      return t("Arkansas");
       break;
    case "CA":
      return t("California");
      break;
    case "CO":
      return t("Colorado");
      break;
    case "CT":
      return t("Connecticut");
      break;
    case "DE":
      return t("Delaware");
      break;
    case "DC":
      return t("District of Columbia");
      break;
    case "FM":
      return t("Federated States of Micronesia");
      break;
    case "FL":
      return t("Florida");
      break;
    case "GA":
      return t("Georgia");
      break;
    case "GU":
      return t("Guam");
      break;
    case "HI":
      return t("Hawaii");
      break;
    case "ID":
      return t("Idaho");
      break;
    case "IL":
      return t("Illinois");
      break;
    case "IN":
      return t("Indiana");
      break;
   case "IA":
     return t("Iowa");
     break;
   case "KS":
     return t("Kansas");
     break;
   case "KY":
     return t("Kentucky");
     break;
   case "LA":
     return t("Louisiana");
     break;
   case "ME":
     return t("Maine");
     break;
   case "MD":
     return t("Maryland");
     break;
   case "MH":
     return t("Marshall Islands");
     break;
   case "MA":
     return t("Massachusetts");
     break;
   case "MI":
     return t("Michigan");
     break;
   case "MN":
     return t("Minnesota");
     break;
   case "MS":
     return t("Mississippi");
     break;
   case "MO":
     return t("Missouri");
     break;
   case "MT":
     return t("Montana");
     break;
   case "NE":
     return t("Nebraska");
     break;
   case "NV":
     return t("Nevada");
     break;
   case "NH":
     return t("New Hampshire");
     break;
   case "NJ":
     return t("New Jersey");
     break;
   case "NM":
     return t("New Mexico");
     break;
   case "NY":
     return t("New York");
     break;
   case "NC":
     return t("North Carolina");
     break;
   case "ND":
     return t("North Dakota");
     break;
   case "OH":
     return t("Ohio");
     break;
   case "OK":
     return t("Oklahoma");
     break;
   case "OR":
     return t("Oregon");
     break;
   case "PA":
     return t("Pennsylvania");
     break;
   case "PR":
     return t("Puerto Rico");
     break;
   case "RI":
     return t("Rhode Island");
     break;
   case "SC":
     return t("South Carolina");
     break;
   case "SD":
     return t("South Dakota");
     break;
   case "TN":
     return t("Tennessee");
     break;
   case "TX":
     return t("Texas");
     break;
   case "UT":
     return t("Utah");
     break;
   case "VT":
     return t("Vermont");
     break;
   case "VA":
     return t("Virginia");
     break;
   case "WA":
     return t("Washington");
     break;
   case "WI":
     return t("Wisconsin");
     break;
   case "WV":
     return t("West Virginia");
     break;
   case "WY":
     return t("Wyoming");
     break;
  }
}


