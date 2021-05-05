
<div id="loadblock" class="text-center" style="position:fixed;top:50%;left:50%;transform:translate(-50%, -50%);display:none;">
    <div class="card">
        <div class="card-body text-center">
            <div class="spinner-border"></div><br>
            <label id="loading-message"></label>
        </div>
    </div>
</div>

<div class="wrap">
    <form method="post" action="options.php">
        <div class="card-header alert-primary">
            <h2>eMediaFinder Settings
                <input name="submit" class="btn btn-primary btn-xl" style="float:right" type="submit" value="<?php esc_attr_e('Save'); ?>" />
            </h2>
        </div>
        <?php
        settings_fields('emdb-publish_options');
        do_settings_fields('emdb-publish', 'api_settings');
        echo '<script>var wpUsers = ', json_encode(get_users($users)), ';</script>';
        ?>
        <!-- TODO: make a dropdown that gets workspaces from emediafinder -->
        <a href="https://entermediadb.org">entermediadb.org</a>
        <div class="alert alert-secondary">
            <p>
                You will need to configure your CDN settings in Catalog Preferences<br>
                you can find them in:
            <pre>/finder/emshare2/views/settings/applicationsetup/parameters/save.html</pre>
            </p>

        </div>
        <div class="table-responsive">
            <table class="table">
                <tr valign="top">
                    <th scope="row"><label for="emdb_main_server">Your eMediaFinder register server</label></th>
                    <td>
                        <input type="text" name="emdb_main_server" id="emdb_main_server" value="<?php echo get_option('emdb_main_server'); ?>" class="form-control" placeholder="https://emediafinder.com" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="emdb_email">Your eMediaFinder email</label></th>
                    <td>
                        <input type="text" name="emdb_email" id="emdb_email" value="<?php echo get_option('emdb_email'); ?>" class="form-control" placeholder="myemail@myhost.com" />
                        <input id="sendemail" class="button button-primary" type="button" value="Activate Account" onclick="sendEmail()" /><br>
                        <!-- <label class="text-muted">You can register your email at <a href="https://emediafinder.com">emediafinder</a></label> -->

                        <div id="alertmail" class="alert alert-success" style="display: none"></div>
                        <div id="alerterror" class="alert alert-danger" style="display: none"></div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="emdb_entermediakey">EntermediaDB Cloud Key</label></th>
                    <td>
                        <input type="text" name="emdb_entermediakey" id="emdb_entermediakey" value="<?php echo get_option('emdb_entermediakey'); ?>" oninput="GetWorkSpaces()" class="form-control" placeholder="apikeyhere" />
                        <label class="text-muted">Corresponds to the Access Key sent to your email</label><br>
                        <!-- <input id="getworkspace" class="button button-primary" type="button" value="Get Workspaces" onclick="GetWorkSpaces()" /> -->
                        <div id="workspacesuccess" class="alert alert-success" style="display: none"></div>
                        <div id="workspacedanger" class="alert alert-danger" style="display: none"></div>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label for="emdb_cdn_prefix">Your Workspaces</label></th>
                    <td>
                        <select id="emcatalogs" name="emcatalogs" id="cataloglist" class="form-select" onchange="SelectWorkspace()"></select>
                        <label class="text-muted">This autofills selected workspace and collection ID</label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="emdb_cdn_prefix">Selected Workspace</label></th>
                    <td>
                        <input type="text" class="form-control" aria-label="Text input with dropdown button" name="emdb_cdn_prefix" id="emdb_cdn_prefix" value="<?php echo get_option('emdb_cdn_prefix'); ?>" placeholder="https://x.x.x.x:xxx">
                        <label class="text-muted">Corresponds to your workspace URL</label>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="emdb_cdn_prefix">Collection ID</label></th>
                    <td>
                        <input type="text" name="emdb_collectionid" id="emdb_collectionid" value="<?php echo get_option('emdb_collectionid'); ?>" class="form-control" />
                        <label class="text-muted">Corresponds to your Colletion ID</label>
                        <input type="text" name="emdb_enabled_users" id="emdb_enabled_users" value="<?php echo get_option('emdb_enabled_users'); ?>" class="form-control" hidden />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="emdb_cdn_prefix">Workspace Admin Key</label></th>
                    <td>
                        <input type="text" name="emdb_adminkey" id="emdb_adminkey" value="<?php echo get_option('emdb_adminkey'); ?>" class="form-control" />
                        <label id="adminkey_warning" class="text-danger"></label>
                    </td>
                </tr>
            </table>
        </div>

    </form>

</div>
