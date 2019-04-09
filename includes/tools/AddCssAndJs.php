<?php
namespace tools;
/**
 *
 * @author Ovidio Jose Arteaga
 *
 */
defined("ABSPATH") or die("");

class AddCssAndJs
{
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', array($this, 'addMainJs'));
        add_action( 'wp_enqueue_scripts', array($this, 'addMainCss'));
        add_action( 'admin_enqueue_scripts', array($this, 'addAdminJs'));
        add_action( 'admin_enqueue_scripts', array($this, 'addAdminCss'));
    }
    
    function addMainJs()
    {
        wp_register_script( 'yogurtappmainjs', get_site_url() . "/wp-content/plugins/yogurt-app/assets/js/main.js", '', '1', true );
        wp_enqueue_script( 'yogurtappmainjs' );
        wp_localize_script( 'yogurtappmainjs', 'yogurtappmainjs_vars', ['ajaxurl' => admin_url( 'admin-ajax.php' ) ] );
    }
    
    function addAdminJs()
    {
        wp_register_script( 'yogurtappadminjs', get_site_url() . "/wp-content/plugins/yogurt-app/assets/js/admin.js", '', '1', true );
        wp_enqueue_script( 'yogurtappadminjs' );
        wp_localize_script( 'yogurtappadminjs', 'yogurtappadminjs_vars', ['ajaxurl' => admin_url( 'admin-ajax.php' ) ] );
    }
    
    function addMainCss()
    {
        wp_register_style( 'yogurtappmaincss', get_site_url() . "/wp-content/plugins/yogurt-app/assets/css/main.css", '', 1 );
        wp_enqueue_style( 'yogurtappmaincss' );
    }
    
    function addAdminCss()
    {
        wp_register_style( 'yogurtappadmincss', get_site_url() . "/wp-content/plugins/yogurt-app/assets/css/admin.css", '', 1 );
        wp_enqueue_style( 'yogurtappadmincss' );
    }
}

