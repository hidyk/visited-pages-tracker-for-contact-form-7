<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Plugin Name: Visited Pages Tracker for Contact Form 7
 * Description: Track visited pages and include them in Contact Form 7 submissions.
 * Version: 1.1
 * Author: hidyk
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires Plugins: contact-form-7
 */

//  special mail tag [visited-pages] shortcode for Contact Form 7
add_filter('wpcf7_special_mail_tags', 'vptcf7_visited_pages_mail_tag', 10, 2);

function vptcf7_visited_pages_mail_tag($output, $name) {
    if ($name == 'visited-pages') {
        if (!empty($_POST['visited_pages'])) {

            // _POST['visited_pages'] sanitization and unslashing
            $sanitized_post_value = sanitize_text_field(wp_unslash($_POST['visited_pages']));

            // json_decode
            $visited_pages = json_decode($sanitized_post_value, true);

            // sanitize all of the visited pages array values
            if (is_array($visited_pages)) {
                $sanitized_pages = array_map('sanitize_text_field', $visited_pages);
                $output = "This user's visited pages:\n" . implode("\n", $sanitized_pages);
            } else {
                $output = 'No visited pages recorded.';
            }
        } else {
            $output = 'No visited pages recorded.';
        }
    }
    return $output;
}


// JavaScript reading and storing visited pages
function vptcf7_enqueue_script() {
    wp_enqueue_script('contact-form-7-page-tracker', plugin_dir_url(__FILE__) . 'js/visited-pages-tracker-for-contact-form-7.js', [], '1.1.0', true);
}
add_action('wp_enqueue_scripts', 'vptcf7_enqueue_script');