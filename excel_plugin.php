<?php

/*
Plugin Name: Excell Plugin
Description: Plugin to demonstrate CSV import
Version: 0.1
Author:Manoj Odela
*/

// Create a new table
function plugin_table()
{

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $tablename = $wpdb->prefix . "excellplugin";

    $sql = "CREATE TABLE $tablename (
     id mediumint(11) NOT NULL AUTO_INCREMENT,
     hospital_code varchar(80) NOT NULL,
     hospital_name varchar(100) NOT NULL,
     hospital_address varchar(100) NOT NULL,
     PRIMARY KEY (id)
   ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'plugin_table');

// Add menu
function plugin_menu()
{

    add_menu_page("Excell Plugin", "Excell Plugin", "manage_options", "excellplugin", "displayExcell", plugins_url('/custom_excell_import/img/icon.png'));
}
add_action("admin_menu", "plugin_menu");

function displayExcell()
{
    include "displayExcell.php";
}
