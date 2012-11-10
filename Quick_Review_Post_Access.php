<?php
/**
 * @package Quick Review Post Access
 * @author The Cellar Room Limited
 * @version 1.3.0
 */
/*
Plugin Name: Quick Review Post Access
Version: 1.3.0
Plugin URI: http://thecellarroom.co.uk
Author: The Cellar Room Limited
Author URI: http://www.thecellarroom.co.uk
Description: Adds a link to 'Pending', 'future' (scheduled) and 'Drafts' under the Posts, Pages, and other custom post type sections in the admin menu. Compatible with WordPress 3.0+.

*/

/*
Copyright (c) 2010 by The Cellar Room Limited

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
<a href="../../Utility/functions.php"></a><a href="../../Utility/function-utility.php"></a><a href="../../Utility/function-generic.php"></a>
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

if ( is_admin() && !class_exists( 'TCR_QuickDraftsAccess' ) ) :

class TCR_QuickDraftsAccess {

	function init() {
		add_action( 'admin_menu', array( __CLASS__, 'quick_drafts_access' ) );
	}

	function quick_drafts_access() {
		$post_types = (array) get_post_types( array( 'show_ui' => true ), 'object' );
		$post_types = apply_filters( 'TCR_quick_drafts_access_post_types', $post_types );
		foreach ( $post_types as $post_type ) {
			$name = $post_type->name;
			$num_posts = wp_count_posts( $name, 'readable' );
			$path = 'edit.php';
			if ( 'post' != $name ) // edit.php?post_type=post doesn't work
				$path .= '?post_type=' . $name;
			if ( ( $num_posts->draft > 0 ) || apply_filters( 'TCR_quick_drafts_access_show_if_empty', false, $name, $post_type ) )
				add_submenu_page( $path, __( 'Drafts' ), sprintf( __( 'Drafts (%d)' ), $num_posts->draft ), $post_type->cap->edit_posts, "edit.php?post_type=$name&post_status=draft" );
		}
	}

}

TCR_QuickDraftsAccess::init();

endif;
?>
<?php
if ( is_admin() && !class_exists( 'TCR_QuickPendingAccess' ) ) :

class TCR_QuickPendingAccess {

	function init() {
		add_action( 'admin_menu', array( __CLASS__, 'quick_Pending_access' ) );
	}

	function quick_Pending_access() {
		$post_types = (array) get_post_types( array( 'show_ui' => true ), 'object' );
		$post_types = apply_filters( 'TCR_quick_Pending_access_post_types', $post_types );
		foreach ( $post_types as $post_type ) {
			$name = $post_type->name;
			$num_posts = wp_count_posts( $name, 'readable' );
			$path = 'edit.php';
			if ( 'post' != $name ) // edit.php?post_type=post doesn't work
				$path .= '?post_type=' . $name;
			if ( ( $num_posts->pending > 0 ) || apply_filters( 'TCR_quick_Pending_access_show_if_empty', false, $name, $post_type ) )
				add_submenu_page( $path, __( 'Pending' ), sprintf( __( 'Pending (%d)' ), $num_posts->pending ), $post_type->cap->edit_posts, "edit.php?post_type=$name&post_status=pending" );
		}
	}
}

TCR_QuickPendingAccess::init();
endif;
?>
<?php
if ( is_admin() && !class_exists( 'TCR_QuickfutureAccess' ) ) :

class TCR_QuickfutureAccess {

	function init() {
		add_action( 'admin_menu', array( __CLASS__, 'quick_future_access' ) );
	}

	function quick_future_access() {
		$post_types = (array) get_post_types( array( 'show_ui' => true ), 'object' );
		$post_types = apply_filters( 'TCR_quick_future_access_post_types', $post_types );
		foreach ( $post_types as $post_type ) {
			$name = $post_type->name;
			$num_posts = wp_count_posts( $name, 'readable' );
			$path = 'edit.php';
			if ( 'post' != $name ) // edit.php?post_type=post doesn't work
				$path .= '?post_type=' . $name;
			if ( ( $num_posts->future > 0 ) || apply_filters( 'TCR_quick_future_access_show_if_empty', false, $name, $post_type ) )
				add_submenu_page( $path, __( 'future' ), sprintf( __( 'future (%d)' ), $num_posts->future ), $post_type->cap->edit_posts, "edit.php?post_type=$name&post_status=future" );
		}
	}
}

TCR_QuickfutureAccess::init();
endif;
?>