<?php

/*
Plugin Name: Lightweight JS snippet
Plugin URI: https://wordpress.com/plugins/lightweight-js-snippet/
Description: Add JS scipt to one or more pages or posts.
Author: jonashjalmarsson
Version: 1.2
Author URI: https://jonashjalmarsson.se
*/

/*  Copyright 2022 Jonas Hjalmarsson (email: jonas@byjalma.se)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

namespace jhljs;

if ( ! defined( 'ABSPATH' ) ) { return; }

require_once('admin-settings.php');

/**
 * helper class
 **/
class jhljs_script {
	// private $style = '';
	// private $first = true;
    public static function instance() {
        static $instance;
        if ($instance === null)
            $instance = new jhljs_script();
        return $instance;
    }
    private function __construct() { 

	}
	public function getScript() {
		// if ($this->first) {
		// 	$this->first = false;
		// 	return $this->style;
		// }
		// return '';
        $show_in_posts = get_option('jhljs-post');
		if ($show_in_posts != 'null' || $show_in_posts != '') {
            $show_in_posts = \str_replace(' ', '', $show_in_posts);
            $post_id_array = explode(',', $show_in_posts);
            if (in_array(get_the_id(), $post_id_array)) {
                $js = str_replace('&amp;&amp;', '&&', wp_kses(get_option('jhljs-script'),'data'));
                return "<script id='jhljs-script' type='text/javascript'>$js</script>";
            }
		}
	}


}

add_action('wp_head', function() {
	echo jhljs_script::instance()->getScript();
});




