<?php
function cpt_board() {
	$labels = array(
		'name'                  => 'Boards',
		'singular_name'         => 'Board',
		'menu_name'             => 'Boards',
		'name_admin_bar'        => 'Board',
		'archives'              => 'Item Archives',
		'attributes'            => 'Item Attributes',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Items',
		'add_new_item'          => 'Add New Item',
		'add_new'               => 'Add New',
		'new_item'              => 'New Item',
		'edit_item'             => 'Edit Item',
		'update_item'           => 'Update Item',
		'view_item'             => 'View Item',
		'view_items'            => 'View Items',
		'search_items'          => 'Search Item',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into item',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Board',
		'description'           => 'board',
		'labels'                => $labels,
		'supports'              => array( 'custom-fields', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'board', $args );
}
add_action( 'init', 'cpt_board', 0 );

function cpt_widget() {
	$labels = array(
		'name'                  => 'Widgets',
		'singular_name'         => 'Widget',
		'menu_name'             => 'Widgets',
		'name_admin_bar'        => 'Widget',
		'archives'              => 'Item Archives',
		'attributes'            => 'Item Attributes',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Items',
		'add_new_item'          => 'Add New Item',
		'add_new'               => 'Add New',
		'new_item'              => 'New Item',
		'edit_item'             => 'Edit Item',
		'update_item'           => 'Update Item',
		'view_item'             => 'View Item',
		'view_items'            => 'View Items',
		'search_items'          => 'Search Item',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into item',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Widget',
		'description'           => 'Widget',
		'labels'                => $labels,
		'supports'              => array( ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'widget', $args );
}
add_action( 'init', 'cpt_widget', 0 );

/* KEYBOARD MAESTRO - Get Macro list *******************************************
 *                                                                             *
 * Called with ajax, get html for action picker                                *
 *                                                                             *
*******************************************************************************/
function get_km_macro_list() {
    // xml from keyvoard maestro
    ob_start();
    passthru('osascript -e \'tell app "Keyboard Maestro Engine"  to getmacros with asstring \'' , $datas);
    $xml = ob_get_clean();
    // translate xml to php object
    $xml = str_replace(array("\n", "\r", "\t"), '', $xml);
    $xml = trim(str_replace('"', "'", $xml));
    $simpleXml = simplexml_load_string($xml);
    $json = json_encode($simpleXml);
    $arr = json_decode( $json , true );
    // Generate html
    $html = '';
    foreach( $arr['array']['dict'] as $group ) {
        if(  count($group['array']) > 0 ) { // group contain something
        $html .= '<div class="group">'.$group['string'][0].'</div>';
            if ( !array_key_exists('string', $group['array']['dict'] ) ) { // 2 or more macros in the group, so foreach
                foreach( $group['array']['dict'] as $macro ) {
                    // Macro UIID + Label
                    $html .= '<div class="macro" data-value="'.$macro['string'][2].'">'.$macro['string'][0].'</div>';
                }
            }else{ // just one macro in the group so no array inside
                $html .= '<div class="macro" data-value="'.$group['array']['dict']['string'][2].'">'.$group['array']['dict']['string'][0].'</div>';
            }
        }        
    }    
    wp_send_json($html);
}
add_action('wp_ajax_macrolist', 'get_km_macro_list' );
add_action('wp_ajax_nopriv_macrolist', 'get_km_macro_list' );






/* KEYBOARD MAESTRO - Launch a specific KM macro *******************************
 *                                                                             *
*******************************************************************************/ 
function kmr_launch_km_macro() {
    $action = $_POST['macro'] ;
    exec("osascript -e 'tell app \"Keyboard Maestro Engine\" to do script \"$action\"' " );
    wp_send_json('Super');
}
add_action('wp_ajax_launchmacro', 'kmr_launch_km_macro' );
add_action('wp_ajax_nopriv_launchmacro', 'kmr_launch_km_macro' );






/* KEYBOARD MAESTRO - Launch macro with parameter ******************************
 *                                                                             *
*******************************************************************************/
function kmr_launch_km_macro_with_param( ) {
    $action = $_POST['action_uid'] ;
    $param = $_POST['action_param'];
    exec("osascript -e 'tell app \"Keyboard Maestro Engine\" to do script \"$action\" with parameter \"$param\"' " );
    exit(0);
}
add_action('wp_ajax_launchmacrowithparam', 'kmr_get_current_front_app_name' );
add_action('wp_ajax_nopriv_launchmacrowithparam', 'kmr_get_current_front_app_name' );





  
/* SYSTEM - Get finder window path *********************************************
 *                                                                             *
 * allow to switch to board according a particular finder window in front      *
 *                                                                             *
*******************************************************************************/
function kmr_get_current_front_finder_window( ) {
    ob_start();
    passthru("osascript -e 'tell app \"Finder\" to return POSIX path of (insertion location as alias)' ");
    $var = ob_get_clean();
    wp_send_json( $var );
}
add_action('wp_ajax_getCurrentFinderW', 'kmr_get_current_front_finder_window' );
add_action('wp_ajax_nopriv_getCurrentFinderW', 'kmr_get_current_front_finder_window' ); 





/* SYSTEM - Get active app name ************************************************
 *                                                                             *
 * allow to switch to board according to a particular app                      *
 *                                                                             *
*******************************************************************************/
function kmr_get_current_front_app_name( ) {
    ob_start();
    passthru("osascript -e 'tell app \"System Events\" to return the name of application processes whose frontmost is true'");
    $var = ob_get_clean();
    wp_send_json( $var );
}    
add_action('wp_ajax_getcurrentfrontappname', 'kmr_get_current_front_app_name' );
add_action('wp_ajax_nopriv_getcurrentfrontappname', 'kmr_get_current_front_app_name' );  





function kmr_get_maccurrent_infos( ) {
    ob_start();
    passthru("osascript -e 'tell app \"System Events\" to return the name of application processes whose frontmost is true'");
    $app = ob_get_clean();
    ob_start();
    passthru("osascript -e 'tell app \"Finder\" to return POSIX path of (insertion location as alias)'");
    $path = ob_get_clean();
    wp_send_json(array('app'=>trim($app),'path'=>trim($path) ));
}
add_action('wp_ajax_getcurrentmacinfos', 'kmr_get_maccurrent_infos' );
add_action('wp_ajax_nopriv_getcurrentmacinfos', 'kmr_get_maccurrent_infos' );  




/* KMR - SAVE/UPDATE ***********************************************************
 *                                                                             *
*******************************************************************************/
function kmr_save ( $type ) {
    $id = $_POST[$type.'_id'] ;
	if ( empty($id) ) {
		$id = wp_insert_post( array(
				'post_type' => $type ,
				'post_status'	=> 'publish',
			)
		);
	}
	foreach( $_POST as $meta => $value ) {
		if( $meta != 'action' ) {
			update_post_meta( $id , $meta , $value );
		}
	}
    update_post_meta( $id , $type.'_id' , $id );
	$arr = array_merge( $_POST , array($type.'_id'=>$id) ) ;
	wp_send_json( $arr );
}

/* KMR - Save/Upadte Widget ****************************************************
 *                                                                             *
*******************************************************************************/
function kmr_save_widget() {
	kmr_save( 'widget' );
}
add_action('wp_ajax_savewidget', 'kmr_save_widget' );
add_action('wp_ajax_nopriv_savewidget', 'kmr_save_widget' );


/* KMR - Save Board ************************************************************
 *                                                                             *
*******************************************************************************/
function kmr_save_board( ) {
	kmr_save( 'board' );	
}
add_action('wp_ajax_saveboard', 'kmr_save_board' );
add_action('wp_ajax_nopriv_saveboard', 'kmr_save_board' );


/* KMR - DELETE ****************************************************************
 *                                                                             *
*******************************************************************************/
function kmr_delete( $type , $id ) {
    $args = array(
        'post_type' => 'any',
        'meta_key' => $type . '_id',
        'meta_value' => $id ,
        'fields'    => 'ids',
    );
    error_log( $type );
    error_log( $id ) ;
    error_log( print_r($args, true));
    $pids = get_posts( $args ) ;
    error_log( print_r($pids, true));
    if ( !empty( $pids ) ) {
        foreach( $pids as $pid ) {
            wp_delete_post( $pid , true);
        }
    }else{
        wp_send_json('ko');
    }
    wp_send_json('ok');
}


function kmr_delete_board() {
    $id = ( isset($_POST['pid']) ) ? $_POST['pid'] : '' ;
    if ( !empty($id) ) {
        kmr_delete( 'board' , $id ) ;
    }
}
add_action('wp_ajax_deleteboard', 'kmr_delete_board' );
add_action('wp_ajax_nopriv_deleteboard', 'kmr_delete_board' );

function kmr_delete_widget() {
    $id = ( isset($_POST['pid']) ) ? $_POST['pid'] : '' ;
    if ( !empty($id) ) {
        kmr_delete( 'widget' , $id ) ;
    }
}
add_action('wp_ajax_deletewidget', 'kmr_delete_widget' );
add_action('wp_ajax_nopriv_deletewidget', 'kmr_delete_widget' );


/* KMR - GET DATA **************************************************************
 *                                                                             *
*******************************************************************************/
function kmr_get_data( $type ) {
    $args = array(
        'post_type' => $type ,
        'posts_per_page' => -1,
        'fields' => 'ids'
    );
    $elems = get_posts( $args ) ;
    
    $result = array();
    
    if( !empty($elems) ) {
        foreach( $elems as $elemid ) {
            $metas = get_post_meta( $elemid , null , true);
            $arr = array();
            foreach( $metas as $k => $v ) {
                if( is_array($v) ) {
                    $arr[$k] = $v[0];
                }else{
                    $arr[$k] = $v;
                }
            }
            $result[] = array_merge( $arr , array($type.'_id' => $elemid )) ;
        }
    }
    return $result ;
}

/* KMR - Get Boards ************************************************************
 *                                                                             *
*******************************************************************************/
function kmr_get_all_boards() {
    $boards = kmr_get_data('board');
    wp_send_json( $boards );
}
add_action('wp_ajax_getboards', 'kmr_get_all_boards' );
add_action('wp_ajax_nopriv_getboards', 'kmr_get_all_boards' );


/* KMR - Get Widgets ***********************************************************
 *                                                                             *
*******************************************************************************/
function kmr_get_all_widgets() {
    $widgets = kmr_get_data('widget');
    wp_send_json( $widgets );
}
add_action('wp_ajax_getwidgets', 'kmr_get_all_widgets' );
add_action('wp_ajax_nopriv_getwidgets', 'kmr_get_all_widgets' );

/* KMR - Get all datas *********************************************************
 *                                                                             *
*******************************************************************************/
function kmr_get_all_datas() {
    $boards = kmr_get_data('board');
    $widgets = kmr_get_data('widget');
    $result = array(
        'boards' => $boards,
        'widgets' => $widgets
    );
    wp_send_json( $result );
}
add_action('wp_ajax_getdatas', 'kmr_get_all_datas' );
add_action('wp_ajax_nopriv_getdatas', 'kmr_get_all_datas' );


/* THEME - Color picker content ************************************************
 *                                                                             *
*******************************************************************************/
function theme_helper_picker_color_content() {
        $colors=array(
        /* Blue light */
        '002939','003C52','00597C','0078A4','0090CD','00BAFD','00CEFE','6CDFFE','B6EDFE','E8FAFF',
        /* Blue dark */
        '070E44','141666','211585','2E1EAE','4217EE','3653DA','628BFF','97B3FE','C7D9FD','F0F4FF',
        /* Purple */
        '13002D','1C0041','2B0061','380081','4C00A3','6200E5','8A00FB','B05DFC','D6B5FD','F4EAFE',
        /* Mauve */
        '27002E','380045','570066','73008C','9600AD','C400EC','DD00FA','DF56EC','E8A8ED','FEE9FE',
        /* Pink */
        '2E0013','49001B','6D0027','910039','B50044','EF005E','F93B87','FF84AE','FFC2D7','FFEDF3',
        /* Red */
        '470201','6d0708','a2120d','d51a16','f22822','f34a48','f37771','f6a3a0','fbd1d1','fff1f2',
        /* Orange dark */
        '461303','641e06','992a10','cc3c17','f15320','f56f3f','f4936d','f8b79d','fbdbcf','fff5f1',
        /* Orange light */
        '402704','643909','975611','c57219','f49926','f6a340','f7b96c','fad09d','fde7cb','fff8f1',
        /* Yellow dark */
        '422e04','63410c','956914','c48c1f','f6bb2c','f7c041','fad26c','fbdf9e','fdefcc','fefaee',
        /* Yellow light */
        '514f0c','7a7314','b7b024','f2ea33','fdfb4b','fff666','fefa8b','fdfbb0','fdfdd8','fffff2',
        /* Green light */
        '3f400d','5b6312','8b9720','b7c92e','d1e942','deea60','e5f084','eef6ad','f4fbd4','fefef3',
        /* Green dark */
        '1e2d0e','2b4617','416824','568c2d','66ad3a','86cc56','a4d97d','c3e5a8','dae8cb','f7fef5',
        /* Gray */
        '1a1a1a','343434','4d4d4d','666666','808080','9b9b9b','b3b3b3','cccccc','e6e6e6','fafafa',
        /* B&W */
        '000000','ffffff',
    );
	$i = 1 ;
	foreach($colors as $color){

        echo '<div style="background-color:#'.$color.';" data-value="'.$color.'" '.(($color == 'ffffff') ? 'class="bordered"':'').'></div>';
    	$i++;
	}
}

/* THEME - Icon picker content *************************************************
 *                                                                             *
*******************************************************************************/
function theme_helper_picker_icon_content() {
    $icons = array(
        'Web Application Icons'     => array(
            'fa-address-book','fa-address-book-o','fa-address-card','fa-address-card-o','fa-adjust','fa-american-sign-language-interpreting','fa-anchor','fa-archive','fa-area-chart','fa-arrows','fa-arrows-v','fa-asl-interpreting','fa-assistive-listening-systems','fa-asterisk','fa-at','fa-audio-description','fa-automobile','fa-balance-scale','fa-ban','fa-bank','fa-bar-chart','fa-bar-chart-o','fa-barcode','fa-bars','fa-bath','fa-bathtub','fa-battery','fa-battery-0','fa-battery-1','fa-battery-2','fa-battery-3','fa-battery-4','fa-battery-empty','fa-battery-full','fa-battery-half','fa-battery-quarter','fa-battery-three-quarters','fa-bed','fa-beer','fa-bell','fa-bell-o','fa-bell-slash','fa-bell-slash-o','fa-bicycle','fa-binoculars','fa-birthday-cake','fa-blind','fa-bluetooth','fa-bluetooth-b','fa-bolt','fa-bomb','fa-book','fa-bookmark','fa-bookmark-o','fa-braille','fa-briefcase','fa-bug','fa-building','fa-building-o','fa-bullhorn','fa-bullseye','fa-bus','fa-cab','fa-calculator','fa-calendar','fa-calendar-check-o','fa-calendar-minus-o','fa-calendar-o','fa-calendar-plus-o','fa-calendar-times-o','fa-camera','fa-camera-retro','fa-car','fa-caret-square-o-down','fa-caret-square-o-left','fa-caret-square-o-right','fa-caret-square-o-up','fa-cart-arrow-down','fa-cart-plus','fa-cc','fa-certificate','fa-check','fa-check-circle','fa-check-circle-o','fa-check-square','fa-check-square-o','fa-child','fa-circle','fa-circle-o','fa-circle-o-notch','fa-circle-thin','fa-clock-o','fa-clone','fa-close','fa-cloud','fa-cloud-download','fa-cloud-upload','fa-code','fa-code-fork','fa-coffee','fa-cog','fa-cogs','fa-comment','fa-comment-o','fa-commenting','fa-commenting-o','fa-comments','fa-comments-o','fa-compass','fa-copyright','fa-creative-commons','fa-credit-card','fa-credit-card-alt','fa-crop','fa-crosshairs','fa-cube','fa-cubes','fa-cutlery','fa-dashboard','fa-database','fa-deaf','fa-deafness','fa-desktop','fa-diamond','fa-dot-circle-o','fa-download','fa-drivers-license-o','fa-edit','fa-ellipsis-h','fa-ellipsis-v','fa-envelope','fa-envelope-o','fa-envelope-open','fa-envelope-open-o','fa-envelope-square','fa-eraser','fa-exchange','fa-exclamation','fa-exclamation-circle','fa-exclamation-triangle','fa-external-link','fa-external-link-square','fa-eye','fa-eye-slash','fa-eyedropper','fa-fax','fa-feed','fa-female','fa-fighter-jet','fa-file-archive-o','fa-file-audio-o','fa-file-code-o','fa-file-excel-o','fa-file-image-o','fa-file-movie-o','fa-file-pdf-o','fa-file-photo-o','fa-file-picture-o','fa-file-powerpoint-o','fa-file-sound-o','fa-file-video-o','fa-file-word-o','fa-file-zip-o','fa-film','fa-filter','fa-fire','fa-fire-extinguisher','fa-flag','fa-flag-checkered','fa-flag-o','fa-flash','fa-flask','fa-folder','fa-folder-o','fa-folder-open','fa-folder-open-o','fa-frown-o','fa-futbol-o','fa-gamepad','fa-gavel','fa-gear','fa-gears','fa-gift','fa-glass','fa-globe','fa-graduation-cap','fa-group','fa-hand-grab-o','fa-hand-lizard-o','fa-hand-paper-o','fa-hand-peace-o','fa-hand-pointer-o','fa-hand-rock-o','fa-hand-scissors-o','fa-hand-spock-o','fa-hand-stop-o','fa-handshake-o','fa-hard-of-hearing','fa-hashtag','fa-hdd-o','fa-headphones','fa-heart','fa-heart-o','fa-heartbeat','fa-history','fa-home','fa-hotel','fa-hourglass','fa-hourglass-1','fa-hourglass-2','fa-hourglass-3','fa-hourglass-end','fa-hourglass-half','fa-hourglass-o','fa-hourglass-start','fa-i-cursor','fa-id-badge','fa-id-card','fa-id-card-o','fa-image','fa-inbox','fa-industry','fa-info','fa-info-circle','fa-institution','fa-key','fa-keyboard-o','fa-language','fa-laptop','fa-leaf','fa-legal','fa-lemon-o','fa-level-down','fa-level-up','fa-life-bouy','fa-life-buoy','fa-life-ring','fa-life-saver','fa-lightbulb-o','fa-line-chart','fa-location-arrow','fa-lock','fa-low-vision','fa-magic','fa-magnet','fa-mail-forward','fa-mail-reply','fa-mail-reply-all','fa-male','fa-map','fa-map-marker','fa-map-o','fa-map-pin','fa-map-signs','fa-meh-o','fa-microchip','fa-microphone','fa-microphone-slash','fa-minus','fa-minus-circle','fa-minus-square','fa-minus-square-o','fa-mobile','fa-mobile-phone','fa-money','fa-moon-o','fa-mortar-board','fa-motorcycle','fa-mouse-pointer','fa-music','fa-navicon','fa-newspaper-o','fa-object-group','fa-object-ungroup','fa-paint-brush','fa-paper-plane','fa-paper-plane-o','fa-paw','fa-pencil','fa-pencil-square','fa-pencil-square-o','fa-percent','fa-phone','fa-phone-square','fa-photo','fa-picture-o','fa-pie-chart','fa-plane','fa-plug','fa-plus','fa-plus-circle','fa-plus-square','fa-plus-square-o','fa-podcast','fa-power-off','fa-print','fa-puzzle-piece','fa-qrcode','fa-question','fa-question-circle','fa-question-circle-o','fa-quote-left','fa-quote-right','fa-random','fa-recycle','fa-refresh','fa-registered','fa-remove','fa-reorder','fa-reply','fa-reply-all','fa-retweet','fa-road','fa-rocket','fa-rss','fa-rss-square','fa-s15','fa-search','fa-search-minus','fa-search-plus','fa-send','fa-send-o','fa-server','fa-share','fa-share-alt','fa-share-alt-square','fa-share-square','fa-share-square-o','fa-shield','fa-ship','fa-shopping-bag','fa-shopping-basket','fa-shopping-cart','fa-shower','fa-sign-in','fa-sign-language','fa-sign-out','fa-signal','fa-signing','fa-sitemap','fa-sliders','fa-smile-o','fa-snowflake-o','fa-soccer-ball-o','fa-sort','fa-sort-alpha-asc','fa-sort-alpha-desc','fa-sort-amount-asc','fa-sort-amount-desc','fa-sort-asc','fa-sort-desc','fa-sort-down','fa-sort-numeric-asc','fa-sort-numeric-desc','fa-sort-up','fa-space-shuttle','fa-spinner','fa-spoon','fa-square','fa-square-o','fa-star','fa-star-half','fa-star-half-empty','fa-star-half-full','fa-star-half-o','fa-star-o','fa-sticky-note','fa-sticky-note-o','fa-street-view','fa-suitcase','fa-sun-o','fa-support','fa-tablet','fa-tachometer','fa-tag','fa-tags','fa-tasks','fa-taxi','fa-television','fa-terminal','fa-thermometer','fa-thermometer-0','fa-thermometer-1','fa-thermometer-2','fa-thermometer-3','fa-thermometer-4','fa-thermometer-empty','fa-thermometer-full','fa-thermometer-half','fa-thermometer-quarter','fa-thermometer-three-quarters','fa-thumb-tack','fa-thumbs-down','fa-thumbs-o-down','fa-thumbs-o-up','fa-thumbs-up','fa-ticket','fa-times','fa-times-circle','fa-times-circle-o','fa-times-rectangle','fa-times-rectangle-o','fa-tint','fa-toggle-down','fa-toggle-left','fa-toggle-off','fa-toggle-on','fa-toggle-right','fa-toggle-up','fa-trademark','fa-trash','fa-trash-o','fa-tree','fa-trophy','fa-truck','fa-tty','fa-tv','fa-umbrella','fa-universal-access','fa-university','fa-unlock','fa-unlock-alt','fa-unsorted','fa-upload','fa-user','fa-user-circle','fa-user-circle-o','fa-user-o','fa-user-plus','fa-user-secret','fa-user-times','fa-users','fa-vcard','fa-vcard-o','fa-video-camera','fa-volume-control-phone','fa-volume-down','fa-volume-off','fa-volume-up','fa-warning','fa-wheelchair','fa-wheelchair-alt','fa-wifi','fa-window-close','fa-window-close-o','fa-window-maximize','fa-window-minimize','fa-window-restore','fa fa-wrench',
        ),
        'Accessibility Icons'       => array(
            'fa-american-sign-language-interpreting','fa-asl-interpreting','fa-assistive-listening-systems','fa-audio-description','fa-blind','fa-braille','fa-cc','fa-deaf','fa-deafness','fa-hard-of-hearing','fa-low-vision','fa-question-circle-o','fa-sign-language','fa-signing','fa-tty','fa-universal-access','fa-volume-control-phone','fa-wheelchair','fa-wheelchair-alt',
        ),
        'Hand Icons'                => array(
            'fa-hand-grab-o','fa-hand-lizard-o','fa-hand-o-down','fa-hand-o-left','fa-hand-o-right','fa-hand-o-up','fa-hand-paper-o','fa-hand-peace-o','fa-hand-pointer-o','fa-hand-rock-o','fa-hand-scissors-o','fa-hand-spock-o','fa-hand-stop-o','fa-thumbs-down','fa-thumbs-o-down','fa-thumbs-o-up','fa-thumbs-up',
        ),
        'Transportation Icons'      => array(
            'fa-ambulance','fa-automobile','fa-bicycle','fa-bus','fa-cab','fa-car','fa-fighter-jet','fa-motorcycle','fa-plane','fa-rocket','fa-ship','fa-space-shuttle','fa-subway','fa-taxi','fa-train','fa-truck','fa-wheelchair','fa-wheelchair-alt',
        ),
        'Gender Icons'              => array(
            'fa-genderless','fa-intersex','fa-mars','fa-mars-double','fa-mars-stroke','fa-mars-stroke-h','fa-mars-stroke-v','fa-mercury','fa-neuter','fa-transgender','fa-transgender-alt','fa-venus','fa-venus-double','fa-venus-mars',
        ),
        'File Type Icons'           => array(
            'fa-file','fa-file-archive-o','fa-file-audio-o','fa-file-code-o','fa-file-excel-o','fa-file-image-o','fa-file-movie-o','fa-file-o','fa-file-pdf-o','fa-file-photo-o','fa-file-picture-o','fa-file-powerpoint-o','fa-file-sound-o','fa-file-text','fa-file-text-o','fa-file-video-o','fa-file-word-o','fa-file-zip-o',
        ),
        'Spinner Icons'             => array(
            'fa-circle-o-notch','fa-cog','fa-gear','fa-refresh','fa fa-spinner',
        ),
        'Form Control Icons'        => array(
            'fa-check-square','fa-check-square-o','fa-circle','fa-circle-o','fa-dot-circle-o','fa-minus-square','fa-minus-square-o','fa-plus-square','fa-plus-square-o','fa-square','fa-square-o',
        ),
        'Payment Icons'             => array(
            'fa-cc-amex','fa-cc-diners-club','fa-cc-discover','fa-cc-jcb','fa-cc-mastercard','fa-cc-paypal','fa-cc-stripe','fa-cc-visa','fa-credit-card','fa-credit-card-alt','fa-google-wallet','fa fa-paypal',
        ),
        'Chart Icons'               => array(
            'fa-area-chart','fa-bar-chart','fa-bar-chart-o','fa-line-chart','fa-pie-chart',
        ),
        'Currency Icons'            => array(
            'fa-bitcoin','fa-btc','fa-cny','fa-dollar','fa-eur','fa-euro','fa-gbp','fa-gg','fa-gg-circle','fa-ils','fa-inr','fa-jpy','fa-krw','fa-money','fa-rmb','fa-rouble','fa-rub','fa-ruble','fa-rupee','fa-shekel','fa-sheqel','fa-try','fa-turkish-lira','fa-usd','fa-won','fa-yen',
        ),
        'Text Editor Icons'         => array(
            'fa-align-center','fa-align-justify','fa-align-left','fa-align-right','fa-bold','fa-chain','fa-chain-broken','fa-clipboard','fa-columns','fa-copy','fa-cut','fa-dedent','fa-eraser','fa-file','fa-file-o','fa-file-text','fa-file-text-o','fa-files-o','fa-floppy-o','fa-font','fa-header','fa-indent','fa-italic','fa-link','fa-list','fa-list-alt','fa-list-ol','fa-list-ul','fa-outdent','fa-paperclip','fa-paragraph','fa-paste','fa-repeat','fa-rotate-left','fa-rotate-right','fa-save','fa-scissors','fa-strikethrough','fa-subscript','fa-superscript','fa-table','fa-text-height','fa-text-width','fa-th','fa-th-large','fa-th-list','fa-underline','fa-undo','fa fa-unlink',
        ),
        'Directional Icons'         => array(
            'fa-angle-double-down','fa-angle-double-left','fa-angle-double-right','fa-angle-double-up','fa-angle-down','fa-angle-left','fa-angle-right','fa-angle-up','fa-arrow-circle-down','fa-arrow-circle-left','fa-arrow-circle-o-down','fa-arrow-circle-o-left','fa-arrow-circle-o-right','fa-arrow-circle-o-up','fa-arrow-circle-right','fa-arrow-circle-up','fa-arrow-down','fa-arrow-left','fa-arrow-right','fa-arrow-up','fa-arrows','fa-arrows-alt','fa-arrows-h','fa-arrows-v','fa-caret-down','fa-caret-left','fa-caret-right','fa-caret-square-o-down','fa-caret-square-o-left','fa-caret-square-o-right','fa-caret-square-o-up','fa-caret-up','fa-chevron-circle-down','fa-chevron-circle-left','fa-chevron-circle-right','fa-chevron-circle-up','fa-chevron-down','fa-chevron-left','fa-chevron-right','fa-chevron-up','fa-exchange','fa-hand-o-down','fa-hand-o-left','fa-hand-o-right','fa-hand-o-up','fa-long-arrow-down','fa-long-arrow-left','fa-long-arrow-right','fa-long-arrow-up','fa-toggle-down','fa-toggle-left','fa-toggle-right','fa-toggle-up',
        ),
        'Video Player Icons'        => array(
            'fa-arrows-alt','fa-backward','fa-compress','fa-eject','fa-expand','fa-fast-backward','fa-fast-forward','fa-forward','fa-pause','fa-pause-circle','fa-pause-circle-o','fa-play','fa-play-circle','fa-play-circle-o','fa-random','fa-step-backward','fa-step-forward','fa-stop','fa-stop-circle','fa-stop-circle-o','fa-youtube-play',
        ),
        'Brand Icons'               => array(
            'fa-500px','fa-adn','fa-amazon','fa-android','fa-angellist','fa-apple','fa-bandcamp','fa-behance','fa-behance-square','fa-bitbucket','fa-bitbucket-square','fa-bitcoin','fa-black-tie','fa-bluetooth','fa-bluetooth-b','fa-btc','fa-buysellads','fa-cc-amex','fa-cc-diners-club','fa-cc-discover','fa-cc-jcb','fa-cc-mastercard','fa-cc-paypal','fa-cc-stripe','fa-cc-visa','fa-chrome','fa-codepen','fa-codiepie','fa-connectdevelop','fa-contao','fa-css3','fa-dashcube','fa-delicious','fa-deviantart','fa-digg','fa-dribbble','fa-dropbox','fa-drupal','fa-edge','fa-eercast','fa-empire','fa-envira','fa-etsy','fa-expeditedssl','fa-fa','fa-facebook','fa-facebook-f','fa-facebook-official','fa-facebook-square','fa-firefox','fa-first-order','fa-flickr','fa-font-awesome','fa-fonticons','fa-fort-awesome','fa-forumbee','fa-foursquare','fa-free-code-camp','fa-ge','fa-get-pocket','fa-gg','fa-gg-circle','fa-git','fa-git-square','fa-github','fa-github-alt','fa-github-square','fa-gitlab','fa-gittip','fa-glide','fa-glide-g','fa-google','fa-google-plus','fa-google-plus-circle','fa-google-plus-official','fa-google-plus-square','fa-google-wallet','fa-gratipay','fa-grav','fa-hacker-news','fa-houzz','fa-html5','fa-imdb','fa-instagram','fa-internet-explorer','fa-ioxhost','fa-joomla','fa-jsfiddle','fa-lastfm','fa-lastfm-square','fa-leanpub','fa-linkedin','fa-linkedin-square','fa-linode','fa-linux','fa-maxcdn','fa-meanpath','fa-medium','fa-meetup','fa-mixcloud','fa-modx','fa-odnoklassniki','fa-odnoklassniki-square','fa-opencart','fa-openid','fa-opera','fa-optin-monster','fa-pagelines','fa-paypal','fa-pied-piper','fa-pied-piper-alt','fa-pied-piper-pp','fa-pinterest','fa-pinterest-p','fa-pinterest-square','fa-product-hunt','fa-qq','fa-quora','fa-ra','fa-ravelry','fa-rebel','fa-reddit','fa-reddit-alien','fa-reddit-square','fa-renren','fa-resistance','fa-safari','fa-scribd','fa-sellsy','fa-share-alt','fa-share-alt-square','fa-shirtsinbulk','fa-simplybuilt','fa-skyatlas','fa-skype','fa-slack','fa-slideshare','fa-snapchat','fa-snapchat-ghost','fa-snapchat-square','fa-soundcloud','fa-spotify','fa-stack-exchange','fa-stack-overflow','fa-steam','fa-steam-square','fa-stumbleupon','fa-stumbleupon-circle','fa-superpowers','fa-telegram','fa-tencent-weibo','fa-themeisle','fa-trello','fa-tripadvisor','fa-tumblr','fa-tumblr-square','fa-twitch','fa-twitter','fa-twitter-square','fa-usb','fa-viacoin','fa-viadeo','fa-viadeo-square','fa-vimeo','fa-vimeo-square','fa-vine','fa-vk','fa-wechat','fa-weibo','fa-weixin','fa-whatsapp','fa-wikipedia-w','fa-windows','fa-wordpress','fa-wpbeginner','fa-wpexplorer','fa-wpforms','fa-xing','fa-xing-square','fa-y-combinator','fa-y-combinator-square','fa-yahoo','fa-yc','fa-yc-square','fa-yelp','fa-yoast','fa-youtube','fa-youtube-play','fa fa-youtube-square',
        ),
        'Medical Icons'             => array(
            'fa-ambulance','fa-h-square','fa-heart','fa-heart-o','fa-heartbeat','fa-hospital-o','fa-medkit','fa-plus-square','fa-stethoscope','fa-user-md','fa-wheelchair','fa-wheelchair-alt',
        ),
    );
    foreach( $icons as $group => $classes ) {
        echo '<span class="icone-section-title">'.$group.'</span>';
        foreach( $classes as $classe ) {
            echo '<div data-value="fa '.$classe.'"><i class="fa '.$classe.'"></i></div>';
        }   
    }
}





















?>