<?php
/**
 *  $theme_directory kommt aus der functions.php
 *
 *  alle Options laden
 */

if(has_template_parts("/options/")){
    get_template_parts("/options/");
}

if(is_mb_admin_user() && has_template_parts("/options/admin/")){
    get_template_parts("/options/admin/");
}