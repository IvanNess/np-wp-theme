<?php

require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
if (isset($_POST['post_id']) && $_POST['post_id'] != 0 && !empty($_POST['post_id'])) {
    if (isset($_POST['upload']) && !empty($_POST['upload'])) {
        echo bf_save_classifieds_meta($_POST['post_id'], $_POST['upload']);
    } else {
        echo 'upload empty';
    }
} else {
    echo 'post_id empty';
}