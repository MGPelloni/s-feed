<div class="sfeed-admin _container">
    <header class="sfeed-header">
        <h1>S-Feed</h1>
        <h2>Access Instagram data to use in your WordPress editor.</h2>
    </header>
    <main class="sfeed-main">
        <div class="sfeed-users">
        <?php
        $sfeed_urls = sfeed_urls_load();

        if ($sfeed_urls):
            foreach ($sfeed_urls as $url):
                $feed = sfeed_get_instagram($url);
                $data = sfeed_parse_url($url);
                $user_status = 'Inactive';

                if ($feed) {
                    $user_status = 'Active';
                }
            ?>
                <div class="sfeed-user -<?= esc_attr(strtolower($user_status)) ?>">
                    <div class="sfeed-user-header">
                        <button class="sfeed-user-remove">✕</button>
                    </div>
                    <form class="sfeed-user-form">
                        <div>
                            <label>S-Feed URL:</label>
                            <input type="text" name="sfeed-url" class="sfeed-url" value="<?= esc_url($url) ?>">
                        </div>
                    </form>
                    <div class="sfeed-grid sfeed-grid-3">
                        <?php 
                        if ($feed) {
                            foreach ($feed as $key => $single) {
                                echo '<img src="' . esc_url($single['image_url']) .'" />';
                            } 
                        }
                        ?>
                    </div>
                    <div class="sfeed-user-options">
                        
                        <?php if ($user_status == 'Active'): ?>
                            <p>To display your feed, use the following code in a "shortcode" block: <code>[sfeed user=<?= esc_attr($data['username']) ?> grid=3 limit=6]</code></p>
                            <p>Adjusting the grid attribute will set the amount of grid columns. Adjusting the limit attribute will set the amount of photos to display.</p>
                            <p>Developers can use the following PHP function to retrieve the Instagram data programatically: <code>sfeed_get_user(<?= esc_html($data['username']) ?>)</code></p>
                        <?php else: ?>
                            <a class="_button sfeed-user-key" target="_blank" href="https://social-feed.tech/">Retrieve S-Feed URL</a>
                            <p>You must be logged into the Instagram account in order to retrieve your S-Feed URL.</p>
                        <?php endif; ?>

                        <p class="sfeed-user-status -<?= esc_attr(strtolower($user_status)) ?>">Status: <?= esc_html($user_status) ?></p>
                    </div>
                </div>
        <?php
            endforeach;
        else:
        ?>
            <div class="sfeed-user">
                <div class="sfeed-user-header">
                    <button class="sfeed-user-remove">✕</button>
                </div>
                <form class="sfeed-user-form">
                    <div><label>S-Feed URL:</label><input type="text" name="sfeed-url" class="sfeed-url" value=""></div>
                </form>
                <div class="sfeed-user-options">
                    <a class="_button sfeed-user-key" target="_blank" href="https://social-feed.tech/">Retrieve S-Feed URL</a>
                    <p>Click "Save" below to register this new S-Feed URL to the database.</p>
                    <p class="sfeed-user-status">Status: New User</p>
                </div>
                <button class="sfeed-user-save">Save</button>
            </div>
        <?php
        endif;
        ?>
        </div>
    </main>
    <footer class="sfeed-footer">
        <button class="sfeed-user-add">Add User</button>
    </footer>
</div>