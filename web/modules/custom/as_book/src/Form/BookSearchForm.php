<?php

namespace Drupal\as_book\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class BookSearchForm.
 *
 * @package Drupal\as_book\Form
 */
class BookSearchForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'book_search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['search'] = [
      '#type' => 'textfield',
      '#title' => $this->t('search'),
      '#description' => $this->t('Barre de recherche de livre en base'),
      '#maxlength' => 255,
      '#size' => 64,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#title' => $this->t('submit'),
      '#description' => $this->t('Submit button to start searching'),
    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Submit'),
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    /*foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
    }*/
    $routeName = 'as_book.default_controller_searchEngine';
    $route_parameters = [
      'keyword' => $form_state->getValue('search'),
    ];
    $form_state->setRedirect($routeName, $route_parameters);
  }

}
