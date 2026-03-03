<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Plugin Name: Visited Pages Tracker for Contact Form 7
 * Description: Track visited pages and include them in Contact Form 7 submissions.
 * Version: 1.2
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

            // _POST['visited_pages'] unslashing and json_decode
            $visited_pages = json_decode(wp_unslash($_POST['visited_pages']), true);

            if (is_array($visited_pages) && !empty($visited_pages)) {
                // check format: new (object array) or old (string array)
                if (is_array($visited_pages[0])) {
                    // new format: [{url, visitedAt}, ...]
                    $timezone_name = wp_timezone_string();
                    $lines = [];
                    $i = 1;
                    foreach ($visited_pages as $page) {
                        $url = esc_url_raw($page['url'] ?? '');
                        $decoded_url = urldecode($url);

                        // get page title from WordPress
                        $title = vptcf7_get_title_from_url($url);

                        $time_str = '';
                        if (!empty($page['visitedAt'])) {
                            $timestamp = strtotime($page['visitedAt']);
                            if ($timestamp !== false) {
                                $time_str = '[' . wp_date('H:i', $timestamp) . '] ';
                            }
                        }

                        if ($title) {
                            $lines[] = $i . '. ' . $time_str . $title . ' - ' . $decoded_url;
                        } else {
                            $lines[] = $i . '. ' . $time_str . $decoded_url;
                        }
                        $i++;
                    }
                    $output = "This user's visited pages (" . $timezone_name . "):\n" . implode("\n", $lines);
                } else {
                    // old format: ["url1", "url2", ...] (backward compatibility)
                    $sanitized_pages = array_map('esc_url_raw', $visited_pages);
                    $output = "This user's visited pages:\n" . implode("\n", $sanitized_pages);
                }
            } else {
                $output = 'No visited pages recorded.';
            }
        } else {
            $output = 'No visited pages recorded.';
        }
    }
    return $output;
}


// Resolve page title from URL
function vptcf7_get_title_from_url($url) {
    // 1. try url_to_postid (works for posts, pages, custom post types)
    $post_id = url_to_postid($url);
    if (!$post_id) {
        // try with decoded URL for non-ASCII slugs
        $post_id = url_to_postid(urldecode($url));
    }
    if ($post_id) {
        return get_the_title($post_id);
    }

    // 2. front page
    $url_trimmed = untrailingslashit($url);
    if ($url_trimmed === untrailingslashit(home_url())) {
        $front_id = get_option('page_on_front');
        if ($front_id) {
            return get_the_title($front_id);
        }
        return get_bloginfo('name');
    }

    // 3. custom post type archive pages (e.g. /works/)
    $path = trim(wp_parse_url($url, PHP_URL_PATH), '/');
    $post_types = get_post_types(['has_archive' => true], 'objects');
    foreach ($post_types as $post_type) {
        $archive_slug = $post_type->has_archive === true ? $post_type->rewrite['slug'] ?? $post_type->name : $post_type->has_archive;
        if ($path === $archive_slug) {
            return $post_type->labels->name;
        }
    }

    return '';
}

// JavaScript reading and storing visited pages
function vptcf7_enqueue_script() {
    wp_enqueue_script('contact-form-7-page-tracker', plugin_dir_url(__FILE__) . 'js/visited-pages-tracker-for-contact-form-7.js', [], '1.2.0', true);
}
add_action('wp_enqueue_scripts', 'vptcf7_enqueue_script');
