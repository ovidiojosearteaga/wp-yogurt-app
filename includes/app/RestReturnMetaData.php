<?php
namespace app;

/**
 *
 * @author Ovidio Jose Arteaga
 *        
 */

class RestReturnMetaData
{

  private $namePostType;
  private $nameFieldToShow;
  private $nameMetaField;

  function __construct($namePostType, $nameFieldToShow, $nameMetaField)
  {
    $this->namePostType     = $namePostType;
    $this->nameFieldToShow  = $nameFieldToShow;
    $this->nameMetaField    = $nameMetaField;

    add_action( 'rest_api_init', array($this, 'createApiPostsMetaField'));
  }

  function createApiPostsMetaField()
  {
    if ($this->namePostType === 'user') {
      $getCallback = array($this, 'addUserMetaData'); 
    } else if ($this->namePostType === 'post') {
      $getCallback = array($this, 'setPostExtraData');
    } else {
      $getCallback = array($this, 'getPostMetaForApi');
    }

    register_rest_field( 
      $this->namePostType, 
      $this->nameFieldToShow, 
      array(
        'get_callback' => $getCallback,
        'update_callback'   => null,
        'schema' => null,
      )
    );
  }

  function setPostExtraData($object)
  {
    $postId = $object['id'];

    if ($this->nameMetaField === 'author_name') {
      $authorId = get_post($postId)->post_author;
      $authorName = ucwords(get_userdata($authorId)->display_name);
      return $authorName; 

    } else if ($this->nameMetaField === 'categories_term') {
      $categoriesId = wp_get_post_categories($postId);

      $categories = array();
      foreach ($categoriesId as $categorieId) {
        $categories[] = get_term($categorieId)->name;
      }
      return $categories; 
    } 
    
  }

  function getPostMetaForApi($object)
  {
    $postId = $object['id'];
    return get_post_meta($postId, $this->nameMetaField, true); 
  }

  function addUserMetaData( $user, $field_name, $request) 
  {
    if ($field_name === 'userThumbnail') {
      return get_usermeta($user['id'], 'userThumbnail', true);
    }

    if ($field_name === 'is_adult') {
      return $this->isAdult($user['id']) ? true : false;
    }

    if ($field_name === 'user_email') {
      $userData = get_userdata($user['id']);
      return $userData->user_email;
    }

    if ($field_name === 'hijos') {
      $user = new UserArtek($user['id'], new UpdateDataSQLServer());
      return $user->getHijos();
    }

    if ($field_name === 'fecha_nacimiento') {
      return get_usermeta($user[ 'id' ], 'fecha_nacimiento', true)->date;
    }

    return get_user_meta( $user[ 'id' ], $this->nameMetaField, true );
  }

  private function isAdult($userId)
  {
    $fecha = new \DateTime();
    $fecha->modify('-18 year'); 
    $fechaNacimiento = new \DateTime(get_usermeta($userId, 'fecha_nacimiento', true)->date); 

    if ($fecha > $fechaNacimiento) {
      return true;
    }

    return false;
  }

}