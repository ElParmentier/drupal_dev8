<?php

namespace Drupal\as_book\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class BookReservationForm.
 *
 * @package Drupal\as_book\Form
 */
class BookReservationForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'book_reservation_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $user = \Drupal::currentUser();

    if ($user->hasPermission('access book reservation form')) {

      $form['book_id'] = [
        '#type' => 'hidden',
        '#title' => $this->t('book_id'),
        '#description' => $this->t('Id of book'),
      ];
      $form['user_id'] = [
        '#type' => 'hidden',
        '#title' => $this->t('user_id'),
      ];

      $form['submit'] = [
          '#type' => 'submit',
          '#value' => t('Submit'),
      ];

      return $form;
    }

    return ['#markup' => 'Veuillez vous connecter pour réserver le livre'];
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $current_uri = \Drupal::request()->getRequestUri();
    $originalBook_id = str_replace('/node/', '', $current_uri);
    $current_user = \Drupal::currentUser();
    $originalUser_id = $current_user->id();

    $submittedBook_id = $form_state->getValue('book_id');
    $submittedUser_id = $form_state->getValue('user_id');

    $invalid_bid = $originalBook_id != $submittedBook_id;
    $invalid_uid = $originalUser_id != $submittedUser_id;

    if($invalid_bid || $invalid_uid) {
      $form_state->setErrorByName('book_id', $this->t('Mauvais format de données'));
    }

    $form['book_id']['#value'] = $submittedBook_id;
    $form['user_id']['#value'] = $submittedUser_id;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    $book_id = $form_state->getValue('book_id');
    $user_id = $form_state->getValue('user_id');

    $node = \Drupal\node\Entity\Node::create([
      'type' => 'reservation',
      'title' => 'Réservation N°'.$book_id.'-'.$user_id,
      'status' => 1,
      'field_book' => $book_id,
      'field_suscriber' => $user_id,
    ]);
    /*foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
    }*/
    if ($node->save()) {
      drupal_set_message('Vous avez réservé le livre ! cool ! ', 'status');
    }
    else {
      drupal_set_message('Problème de réservation', 'error');
    }
  }

}
