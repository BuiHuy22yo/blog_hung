<?php
/**
* Header
*
* @package ctwp
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head() ?>

</head>
<body <?php body_class('theme_custom') ?>>
    <?php
        do_action('before_header');

        do_action('ctwp_header');

        do_action('after_header');

        ?>
