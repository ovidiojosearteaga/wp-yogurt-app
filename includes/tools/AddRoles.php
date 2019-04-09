<?php
namespace tools;

/**
 *
 * @author Ovidio Jose Arteaga
 *        
 */

class AddRoles
{
    public $listUserRoles;
    
    function __construct($listUserRoles)
    {
        $this->listUserRoles = $listUserRoles;
        add_action('init', array($this, 'addListUsersRole'), 11);
    }
    
    function addListUsersRole()
    {
        foreach ($this->listUserRoles as $role) {
            if (! $this->role_exists(new \WP_Roles(), $role['role']))
                $this->addRole($role['role'], $role['display_name'], $role['capabilities']);
        }
    }
    
    function addRole($role, $display_name, $capabilities)
    {
        add_role( $role, $display_name, $capabilities );
    }
    
    function role_exists($objRoles, $role)
    {
        if(! empty($role))
            return $objRoles->is_role( $role );
            
            return false;
    }
    
    static function removeRole($role)
    {
        remove_role($role);
    }
}

