<?php
/**
 * Loads users from the "sfeed:urls" WordPress option.
 *
 * @return array|boolean S-Feed URLs or false if no URLs are found.
 */
function sfeed_urls_load() {
    $option = get_option('sfeed:urls');

    if (!$option) {
        return false;
    }

    return $option;
}

/**
 * Saves users to "sfeed:urls" WordPress option.
 *
 * @return void
 */
function sfeed_save_url() {
    // Nonce check
    if (empty($_POST['nonce'])) {
        wp_send_json_error(new WP_Error('500', 'Missing nonce.'));
    }
    
    if (!wp_verify_nonce(filter_var($_POST['nonce'], FILTER_SANITIZE_STRING), 'sfeed-nonce')) {
        wp_send_json_error(new WP_Error('500', 'Invalid nonce.'));
    }

    // S-Feed URL
    if (empty($_POST['url'])) {
        wp_send_json_error(new WP_Error('500', 'Missing URL.'));
    } 

    $new_url = filter_var($_POST['url'], FILTER_SANITIZE_URL);

    if (filter_var($new_url, FILTER_VALIDATE_URL)) {
        $option_name = 'sfeed:urls';
        $urls = get_option($option_name);

        if ($urls !== false) {
            $url_already_exists = false;

            foreach ($urls as $url) {
                if ($url == $new_url) {
                    $url_already_exists = true;
                }
            }

            if (!$url_already_exists) {
                $urls[] = $new_url;
                update_option($option_name, $urls);
            }
        } else {
            $urls = [$new_url];
            $deprecated = null;
            $autoload = 'no';
            add_option($option_name, $urls, $deprecated, $autoload);
        }
    }

    echo 'S-Feed data saved.';
    wp_die();
}


/**
 * Remove URL from "sfeed:urls" WordPress option.
 *
 * @return void
 */
function sfeed_remove_url() {
    // Nonce check
    if (empty($_POST['nonce'])) {
        wp_send_json_error(new WP_Error('500', 'Missing nonce.'));
    }
    
    if (!wp_verify_nonce(filter_var($_POST['nonce'], FILTER_SANITIZE_STRING), 'sfeed-nonce')) {
        wp_send_json_error(new WP_Error('500', 'Invalid nonce.'));
    }

    // S-Feed URL
    if (empty($_POST['url'])) {
        wp_send_json_error(new WP_Error('500', 'Missing URL.'));
    } 

    $targeted_url = filter_var($_POST['url'], FILTER_SANITIZE_URL);

    if (filter_var($targeted_url, FILTER_VALIDATE_URL)) {
        $option_name = 'sfeed:urls';
        $urls = get_option($option_name);

        if ($urls !== false) {
            $found_url = false;
            $targeted_index = null;

            foreach ($urls as $key => $url) {
                if ($url == $targeted_url) {
                    $found_url = true;
                    $targeted_index = $key;
                }
            }

            if ($targeted_index !== null) {
                array_splice($urls, $targeted_index, 1);
                update_option($option_name, $urls);
            }
        }
    }

    echo 'S-Feed data saved.';
    wp_die();
}