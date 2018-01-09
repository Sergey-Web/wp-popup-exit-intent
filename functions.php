<?php
/**
 * Add script for popup and sending the request AJAX
 */
add_action('wp_head', 'exit_popup', 99);

function exit_popup () {
    wp_enqueue_script( 'exit-popup', get_theme_file_uri( '/snippets/promotions/js/script.js' ), '', '', true );
    wp_enqueue_style( 'exit-popup-css', get_theme_file_uri( '/snippets/promotions/css/exit-popup.css' ) );
    wp_localize_script( 'exit-popup', 'popupAjax', [
            'url'   => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('exit-popup')
        ]
    );
}

add_action('wp_ajax_exit-popup', 'ajax_exit_popup');
add_action('wp_ajax_nopriv_exit-popup', 'ajax_exit_popup');
function ajax_exit_popup() {
    if( !wp_verify_nonce( $_POST['security'], 'exit-popup') ) {
        die(FALSE);
    }

    global $wpdb;
    $table = 'royal_exit_popups';
    $ipUser = $_SERVER['REMOTE_ADDR'];
    $dateCurrent = date('Y-d-m');

	//$wpdb->query( "ALTER TABLE `royal_exit_popups` CHANGE `ip` `ip` VARCHAR(15) NOT NULL" );
	//$wpdb->query( "ALTER TABLE `royal_exit_popups` CHANGE `clicks` `clicks` BOOLEAN NOT NULL" );
	if(is_user_logged_in() ) {
		$idAuthUser = get_the_ID();
		die();
	}

	$getUser = $wpdb->get_results(
		$wpdb->prepare( "SELECT id, ip FROM $table WHERE ip = %s", $ipUser )
	);

	if($getUser[0]->id != FALSE) {
		if($_POST['click'] == 'startQuiz') {
			$test = $wpdb->update( $table, ['clicks' => 1], ['id' => $getUser[0]->id]);
		}
		die(FALSE);
	}

    $wpdb->insert( 'royal_exit_popups', [
        'ip'         => $ipUser,
        'last_shown' => $dateCurrent
    ]);
}

