<?php
/*
Plugin Name: EventsEconomicsMDX
Plugin URI: http://economics.mdx.ac.uk/department/events/
Description: Show post of events' category
Version: 0.1.2
Author: Francisco Manueal Alexander Bueno Pérez
Author URI: https://phoenixalx.github.io/Curriculum/
License: GPLv3  Copyright (c) 2017 Francisco Manueal Alexander Bueno Pérez
GNU GENERAL PUBLIC LICENSE
   Version 3, 29 June 2007
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/
// register  style on initialization

/*function register_style() {

    wp_register_style( 'eventsEconomicsMdx', plugins_url('/css/eventsEconomicsMdx.css', __FILE__), false, '1.0.0', 'all');
}

add_action('init', 'eventsEconomicsMdx');
*/


function shortcode_events($atts, $content = null, $code) {

//Use: [events  limit="3" length_title="50" length_dec="50"  size="50"]
    wp_register_style( 'eventsEconomicsMdx', plugins_url('/css/eventsEconomicsMdx.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_style( 'eventsEconomicsMdx' );
    extract(shortcode_atts(array(
        'limit' => 5,
        'length_title' => 50,
        'length_dec' => 80,
        'size' => 65,
        'category'=>'events'

    ), $atts));

    $query = array('showposts' => $limit,  'category_name' => $category,'orderby'=> 'date', 'order'=>'DESC', 'post_status' => 'publish', 'ignore_sticky_posts' => 1);

    $q = new WP_Query($query);
    $count=0;
    if ($q->have_posts()) :
      $count=$count+1;
      $output  = '';
      $output .= '<ul class="list-news">';

      /* comienzo while */
      while ($q->have_posts()) :
        $q->the_post();
        $output .= '<li>';
        $the_date = get_the_date('jS M Y');
        $output .= '<div class="posts_content">';
        $output .= '<div id="headEvents'.$count.'" class="classHeadEvent"><div id="dateEvent'.$count.'" class="classDateEvent" ><span class="spanDataEvent">'.$the_date.'</span></div><div id="divTitleEvent'.$count.'" class="classDivTitleEvent"><span class="spanClassDivTitleEvent"><b>';
        $output .= wp_html_excerpt (get_the_title(), $length_title );
        $output .= '</b></span></div></div>';
        $output .= '<p></p>';
        $excerpt = get_the_content();
        $excerpt =wpautop( $excerpt );
        //$output .= ($excerpt)?'<p>'.wp_html_excerpt($excerpt,$length_dec).'</p>':'';
        $output .= '<p>'.$excerpt.'</p>';
        $output .= '</div>';
        $output .= '</li>';
      endwhile;
      wp_reset_query();

      $output .= '</ul>';
    endif;

    return $output;

}
add_shortcode('events',    'shortcode_events');
?>
