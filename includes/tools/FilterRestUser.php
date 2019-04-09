<?php
namespace tools;
/**
 *
 * @author Ovidio Jose Arteaga
 *        
 */

class FilterRestUser 
{
  function __construct() 
  {
    add_filter('rest_user_query', array($this, 'showAllUsers'));
  }

  function showAllUsers($prepared_args) 
  {
    unset($prepared_args['has_published_posts']);
    return $prepared_args;
  }
}