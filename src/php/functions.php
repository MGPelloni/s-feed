<?php
/**
 * Retrieve the user's Instagram data with a S-Feed URL.
 *
 * @param string $endpoint The endpoint URL.
 * @return array Instagram data.
 */
function sfeed_get_instagram($endpoint) {
    $res = wp_remote_get($endpoint);

    if (is_wp_error($res)) {
        return false;
    }

    return json_decode(wp_remote_retrieve_body($res), true);
}

/**
 * Retrieve all feeds gathered by the S-Feed plugin.
 *
 * @return array Instagram data sorted by users.
 */
function sfeed_get_data() {
    $data = [];
    $users = sfeed_urls_load();
    
    foreach ($urls as $key => $url) {
        $data[] = sfeed_get_instagram($url);
    }

    return $data;
}

 /**
  * Retrieve a specific user's Instagram feed.
  *
  * @param string $username Instagram username.
  * @return array|boolean Instagram data or false on no user found.
  */
function sfeed_get_user($username) {
    $endpoint = sfeed_get_endpoint($username);
    
    if ($endpoint) {
        return sfeed_get_instagram($endpoint);
    }

    return false;
}

/**
 * Retrieve the S-Feed data origin endpoint from a user account.
 *
 * @param string $username The Instagram username.
 * @return string|boolean The S-Feed endpoint or false on no user found.
 */
function sfeed_get_endpoint($username) {
    $users = sfeed_urls_load();

    foreach ($urls as $key => $url) {
        if (strpos($url, $username) !== false) {
            return $url;
        }
    }

    return false;
}

/**
 * Return the query string of an endpoint.
 *
 * @param string $endpoint The S-Feed endpoint.
 * @return string Query string.
 */
function sfeed_parse_url($endpoint) {
    $data = wp_parse_url($endpoint);
    parse_str($data['query'], $query);
    return $query;
}

/**
 * Shortcode for displaying Instagram feeds.
 *
 * @param array $atts Shortcode attributes.
 * @return string Shortcode HTML.
 */
function sfeed_shortcode($atts) {
    $endpoint = sfeed_get_endpoint($atts['user']);
    $feed = sfeed_get_instagram($endpoint);
    $grid = 3;
    $limit = 3;

    if ($atts['grid']) {
        $grid = $atts['grid'];
    }

    if ($atts['limit']) {
        $limit = $atts['limit'];
    }

    ob_start();
    if ($feed) {
        echo '<div class="sfeed-grid sfeed-grid-' . esc_attr($grid) . '">';
        foreach ($feed as $key => $value) {
            if ($key > $limit - 1) {
                continue;
            }

            echo '<div class="sfeed-aspect"><a href="' . esc_url($value['permalink']) .'"><img src="' . esc_url($value['image_url']) . '" /></a></div>';
        }
        echo '</div>';
    }
    $output = ob_get_contents();
    ob_end_clean();
    
    return $output;
} 
    