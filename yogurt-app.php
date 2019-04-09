<?php
/*
 Plugin Name: Yogurt App
 Plugin URI: https://www.brightgroup.com.co/
 Description: Plugin para gestion de ventas.
 Author: Ovidio Jose Arteaga
 Version: 1
 Author URI: https://ovidiojosearteaga.com/
 */
defined("ABSPATH") or die("");

include "includes/tools/AddCssAndJs.php";
include "includes/tools/AddRoles.php";
include "includes/tools/CustomUserMeta.php";
include "includes/tools/FilterRestUser.php";
include "includes/app/RestReturnMetaData.php";

new tools\AddCssAndJs();
new tools\FilterRestUser();

$listUserRoles = array(
    array(
        'role' => 'vendedor',
        'display_name' => 'Vendedor',
        'capabilities' => array(
            'read' => true,
            'edit_users' => true,
            'list_users' => true,
        )
    ),
    array(
        'role' => 'cliente',
        'display_name' => 'Cliente',
        'capabilities' => array(
            'read' => true
        )
    )
);

new tools\AddRoles($listUserRoles);

$listFields = array(

    array(
      'id' => 'cedula',
      'label' => 'Cédula',
      'placeholder' => 'Cédula',
      'type' => 'number',
      'class' => 'regular-text',
      'max' => '',
      'min' => '0',
      'step' => '1'
    ),
    
    /*
    array(
      'id' => 'apellido2',
      'label' => 'Apellido 2',
      'placeholder' => 'Apellido 2',
      'type' => 'text',
      'class' => 'regular-text'
    ),
    */
  );

  new tools\CustomUserMeta($listFields);

  $returnValuePointUser = new app\RestReturnMetaData('user', 'status', 'wp_capabilities');
  $returnValuePointUser = new app\RestReturnMetaData('user', 'display_name', 'display_name');
  $returnValuePointUser = new app\RestReturnMetaData('user', 'firstname', 'first_name');
  $returnValuePointUser = new app\RestReturnMetaData('user', 'lastname', 'last_name');
  $returnValuePointUser = new app\RestReturnMetaData('user', 'cedula', 'cedula');
