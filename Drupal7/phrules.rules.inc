<?php

/**
 * @file
 * Rules for the PH acidity quiz
 */


/**
 * Implement hook_rules_action_info().
 */
function phrules_rules_action_info() {
  $actions = array(
    'phrules_view_message' => array(
      'label' => t('Add field to total with multiplier'),
      'group' => t('Assessments'),
      'parameter' => array(
        'field' => array(
          'type' => 'text',
          'label' => t('Field'),
          'description' => t("This is the field to add to the total score."),
        ),
        'multiplier' => array(
          'type' => 'decimal', 
          'label' => t('Weight'),
        ),
        'diet_percent' => array(
          'type' => 'decimal',
          'label' => t('Diet Percent'),
        ),
        'metabolic_percent' => array(
          'type' => 'decimal',
          'label' => t('Metabolic Percent'),
        ),
        'drug_percent' => array(
          'type' => 'decimal',
          'label' => t('Drug Percent'),
        ),
        'disease_percent' => array(
          'type' => 'decimal',
          'label' => t('Disease Percent'),
        ),
        'node' => array(
          'type' => 'node',
          'label' => t('Node'),
        ),
      ),
    ),

   'phrules_add_ph_inverted' => array(
      'label' => t('Add a ph field to total with multiplier'),
      'group' => t('Assessments'),
      'parameter' => array(
        'field' => array(
          'type' => 'text',
          'label' => t('Field'),
          'description' => t("This is the field to add to the total score."),
        ),
        'multiplier' => array(
          'type' => 'decimal',
          'label' => t('Weight'),
        ),
        'diet_percent' => array(
          'type' => 'decimal',
          'label' => t('Diet Percent'),
        ),
        'metabolic_percent' => array(
          'type' => 'decimal',
          'label' => t('Metabolic Percent'),
        ),
        'drug_percent' => array(
          'type' => 'decimal',
          'label' => t('Drug Percent'),
        ),
        'disease_percent' => array(
          'type' => 'decimal',
          'label' => t('Disease Percent'),
        ),
        'node' => array(
          'type' => 'node',
          'label' => t('Node'),
        ),
      ),
    ),

    'phrules_zero_totals' => array(
      'label' => t('Zero out all totals'),
      'group' => t('Assessments'),
      'parameter' => array(
        'node' => array(
          'type' => 'node',
          'label' => t('Node'),
        ),
      ),
    ),
  );
  return $actions;
}

/**
 * Clears out the totals for a particular test result.
 */
function phrules_zero_totals($node) {
	if ($node->nid) {
	  $node->field_total_score['und'][0]['value']           = 0;
	  $node->field_total_diet_score['und'][0]['value']      = 0;
	  $node->field_total_metabolic_score['und'][0]['value'] = 0;
	  $node->field_total_drug_score['und'][0]['value']      = 0;
	  $node->field_total_disease_score['und'][0]['value']   = 0;
  }
}

/**
 * Add field to total with multiplier
 */
function phrules_view_message($field, $multiplier, $diet_percent, $metabolic_percent, $drug_percent, $disease_percent, $node) {
  $field = (int)$field;

  $score = $field * $multiplier;
  $diet_score      = $score * ($diet_percent / 100);
  $metabolic_score = $score * ($metabolic_percent / 100);
  $drug_score      = $score * ($drug_percent / 100);
  $disease_score   = $score * ($disease_percent / 100);

  $test_array = array('und'=>array('0'=>array('value'=>123)));

  $node->field_total_score['und'][0]['value']           += $score;
  $node->field_total_diet_score['und'][0]['value']      += $diet_score;
  $node->field_total_metabolic_score['und'][0]['value'] += $metabolic_score;
  $node->field_total_drug_score['und'][0]['value']      += $drug_score;
  $node->field_total_disease_score['und'][0]['value']   += $disease_score;

  node_save($node);
}

/**
 * Add a ph field to total with multiplier
 * For ph fields, add the ph but inverted so so 1 adds 13, 2 adds 12, etc.
 */
function phrules_add_ph_inverted($field, $multiplier, $diet_percent, $metabolic_percent, $drug_percent, $disease_percent, $node) {
  $inverted_field  = $field;
  $score           = $inverted_field * $multiplier;
  $diet_score      = $score * ($diet_percent / 100);
  $metabolic_score = $score * ($metabolic_percent / 100);
  $drug_score      = $score * ($drug_percent / 100);
  $disease_score   = $score * ($disease_percent / 100);

  $node->field_total_score['und'][0]['value']           += $score;
  $node->field_total_diet_score['und'][0]['value']      += $diet_score;
  $node->field_total_metabolic_score['und'][0]['value'] += $metabolic_score;
  $node->field_total_drug_score['und'][0]['value']      += $drug_score;
  $node->field_total_disease_score['und'][0]['value']   += $disease_score;

  node_save($node);
}

?>