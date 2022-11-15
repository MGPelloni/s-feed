/**
 * Static event listeners for the S-Feed adminstration panel.
 */
function sfeed_admin_static_event_listeners() {
    if (document.querySelector('.sfeed-user-add')) {
        document.querySelectorAll('.sfeed-user-add').forEach(elem => {
            elem.addEventListener('click', e => {
                let sfeed_grid = document.querySelector('.sfeed-users');
                let sfeed_html = '<div class="sfeed-user"><div class="sfeed-user-header"><button class="sfeed-user-remove">✕</button></div><form class="sfeed-user-form"><div><label>S-Feed URL:</label><input type="text" name="sfeed-url" class="sfeed-url" value=""> </div> </form><div class="sfeed-user-options"><a class="_button sfeed-user-key" target="_blank" href="https://social-feed.tech/">Retrieve S-Feed URL</a><p>Click "Save" below to register this new S-Feed URL to the database.</p><p class="sfeed-user-status">Status: New User</p></div><button class="sfeed-user-save">Save</button></div>';
                sfeed_grid.innerHTML += sfeed_html;

                sfeed_admin_dynamic_event_listeners();
            });
        });
    }
}
window.addEventListener('DOMContentLoaded', sfeed_admin_static_event_listeners);

/**
 * Dynamic event listeners for the S-Feed adminstration panel.
 */
function sfeed_admin_dynamic_event_listeners() {
    // Buttons to remove locations
    if (document.querySelector('.sfeed-user-remove')) {
        document.querySelectorAll('.sfeed-user-remove').forEach(elem => {
            elem.addEventListener('click', e => {
                if (confirm('Are you sure you want to remove this user?')) {
                    sfeed_remove_url(elem.closest('.sfeed-user').querySelector('input.sfeed-url').value);
                    e.target.closest('.sfeed-user').remove();
                }
            });
        });
    }

    if (document.querySelector('.sfeed-user-save')) {
        document.querySelectorAll('.sfeed-user-save').forEach(elem => {
            elem.addEventListener('click', e => {
                elem.disabled = true;
                elem.innerText = 'Saving..';
                sfeed_save_url(elem.closest('.sfeed-user').querySelector('input.sfeed-url').value);
            });
        });
    }
}
window.addEventListener('DOMContentLoaded', sfeed_admin_dynamic_event_listeners);

/**
 * Saves S-Feed admin panel data via Fetch API.
 */
function sfeed_save_url(url) {
    let req = encodeURIComponent(url);
    console.log('Request:', req);

    fetch(sfeed.ajaxurl, {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/x-www-form-urlencoded'
        }),
        credentials: 'same-origin',
        body: 'action=sfeed_save_url&url=' + req + '&nonce=' + sfeed.nonce,
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response:', data);

        document.querySelectorAll('.sfeed-user-save').forEach(elem => {
            elem.innerText = 'Saved!';
        });

        setTimeout(() => {
            document.querySelectorAll('.sfeed-user-save').forEach(elem => {
                elem.disabled = false;
                elem.innerText = 'Save';
                window.location.reload();
            });
        }, 1000);

    })
    .catch(function (error) {
        console.log(error);
        return error;
    });
}

/**
 * Removes S-Feed admin panel data via Fetch API.
 */
 function sfeed_remove_url(url) {
    let req = encodeURIComponent(url);
    console.log('Request:', req);

    fetch(sfeed.ajaxurl, {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/x-www-form-urlencoded'
        }),
        credentials: 'same-origin',
        body: 'action=sfeed_remove_url&url=' + req + '&nonce=' + sfeed.nonce,
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response:', data);
    })
    .catch(function (error) {
        console.log(error);
        return error;
    });
}