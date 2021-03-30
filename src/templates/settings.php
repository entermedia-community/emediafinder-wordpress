<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<style>
    .wp-core-ui select.form-select {
        display: block;
        width: 100%;
        max-width: 100%;
        padding: .375rem 2.25rem .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right .75rem center;
        background-size: 16px 12px;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
</style>


<div class="wrap">
    <h2>eMediaFinder Settings</h2>
    <form method="post" action="options.php">
        <?php
        settings_fields('emdb-publish_options');
        do_settings_fields('emdb-publish', 'api_settings');
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
                    <th scope="row"><label for="emdb_email">Your eMediaFinder email</label></th>
                    <td>
                        <input type="text" name="emdb_email" id="emdb_email" value="<?php echo get_option('emdb_email'); ?>" class="form-control" placeholder="myemail@myhost.com" />
                        <label class="text-muted">You can register your email at <a href="https://emediafinder.com">emediafinder</a></label>
                    </td>
                </tr>
                <tr>
                    <td><input id="sendemail" class="button button-primary" type="button" value="Send Email" onclick="sendEmail()" /></td>
                    <td>
                        <div id="alertmail" class="alert alert-success" style="display: none"></div>
                        <div id="alerterror" class="alert alert-danger" style="display: none"></div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="emdb_entermediakey">EntermediaDB Cloud Key</label></th>
                    <td>
                        <input type="text" name="emdb_entermediakey" id="emdb_entermediakey" value="<?php echo get_option('emdb_entermediakey'); ?>" class="form-control" placeholder="apikeyhere" />
                        <label class="text-muted">Corresponds to the Access Key sent to your email</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="getworkspace" class="button button-primary" type="button" value="Get Workspaces" onclick="getWorkSpaces()" />
                    </td>
                    <td>
                        <div id="workspacesuccess" class="alert alert-success" style="display: none"></div>
                        <div id="workspacedanger" class="alert alert-danger" style="display: none"></div>
                    </td>
                </tr>

                <tr valign="top">
                    <!-- <th scope="row"><label for="emdb_cdn_prefix">Catalog</label></th>
                <td>
                    <input type="text" name="emdb_cdn_prefix" id="emdb_cdn_prefix" value="<?php echo get_option('emdb_cdn_prefix'); ?>" placeholder="https://x.x.x.x:xxx" />
                    <span style="padding-left:5em;">corresponds to catalogsettings/cdn_prefix (domain for your EnterMedia server if not set)</span>
                </td> -->
                    <!-- adminmd5421c0af185908a6c0c40d50fd5e3f16760d5580bc -->
                    <!-- https://critobaltunnel.t47.entermediadb.net -->
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
                    </td>
                </tr>
            </table>
        </div>



        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save'); ?>" />

    </form>
</div>

<script>
    // const emHost = 'http://localhost:8080';
    const emHost = 'https://emediafinder.com';
    var workspaces;

    function init() {
        const emKey = document.getElementById('emdb_entermediakey');
        if (emKey && emKey.value) {
            getWorkSpaces();
            const workspaceSelect = document.getElementById('emcatalogs');
        }
    }

    if (!Array.prototype.find) {
        Object.defineProperty(Array.prototype, 'find', {
            enumerable: false,
            configurable: true,
            writable: true,
            value: function(predicate) {
                if (this == null) {
                    throw new TypeError('Array.prototype.find called on null or undefined');
                }
                if (typeof predicate !== 'function') {
                    throw new TypeError('predicate must be a function');
                }
                var list = Object(this);
                var length = list.length >>> 0;
                var thisArg = arguments[1];
                var value;

                for (var i = 0; i < length; i++) {
                    if (i in list) {
                        value = list[i];
                        if (predicate.call(thisArg, value, i, list)) {
                            return value;
                        }
                    }
                }
                return undefined;
            }
        });
    }

    // function HttpGet(url) {
    //     var xmlHttp = new XMLHttpRequest();
    //     xmlHttp.open("GET", url, false);
    //     xmlHttp.send(null);
    //     return xmlHttp; //.responseText;
    // }

    function HttpPost(url, data) {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("POST", url, false);
        xmlHttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xmlHttp.send(JSON.stringify(data));
        return xmlHttp;
    }

    function alertEmail(message, divid) {
        const alertDiv = document.getElementById(divid);
        alertDiv.style.display = "block";
        alertDiv.innerHTML = message;
        setTimeout(() => {
            alertDiv.style.display = "none";
        }, 5000);
    }

    function sendEmail() {
        const email = document.getElementById('emdb_email');
        if (!email.value) {
            alertEmail('Please type your email', 'alerterror');
            return;
        }
        const urlPath = '/entermediadb/mediadb/services/authentication/emailwordpress.json'
        const encodedEmail = encodeURIComponent(email.value);
        const url = encodeURI(`${emHost}${urlPath}?to=`); // dont re-encode email here
        const resp = HttpPost(url + encodedEmail, {});
        if (resp.status === 200) {
            alertEmail('Email sent, please check your email don\'t forget to check spam folder', 'alertmail');
        } else {
            alertEmail('Please type a registered email', 'alerterror');
        }
    }

    function SelectWorkspace() {
        const selectCat = document.getElementById('emcatalogs');
        const workspace = workspaces.workspaces.find(x => x.url === selectCat.value);
        document.getElementById('emdb_cdn_prefix').value = workspace.url;
        document.getElementById('emdb_collectionid').value = workspace.collectionid;
        getWorkSpaces();
    }

    function NoWorkspace() {
        const workspaceSelect = document.getElementById('catalogdropdown');
        const li = document.createElement('li');
        li.innerHTML = `<button class="dropdown-item" href="#" disabled>No Workspace found</button>`
        workspaceSelect.appendChild(li);
    }

    function getWorkSpaces() {
        var urlPath = "/entermediadb/mediadb/services/authentication/workspacesonteam.json";
        const emKey = document.getElementById('emdb_entermediakey');
        const encodedKey = encodeURIComponent(emKey.value);
        const url = encodeURI(`${emHost}${urlPath}?entermedia.key=`); // dont re-encode email here
        const resp = HttpPost(url + encodedKey, {});
        if (resp.status === 200) {
            workspaces = JSON.parse(resp.response);
            const workspaceSelect = document.getElementById('emcatalogs');
            workspaceSelect.innerHTML = '';
            const selectOpt = document.createElement('option');
            selectOpt.text = "-- Select Workspace URL --";
            selectOpt.hidden = true;
            workspaceSelect.add(selectOpt);
            if (workspaces.workspaces.length > 0) {
                workspaces.workspaces.forEach(w => {
                    const option = document.createElement('option');
                    option.value = w.url;
                    option.text = w.url;
                    workspaceSelect.add(option);
                });
            } else {
                NoWorkspace();
            }
        } else {
            NoWorkspace();
        }
    }
    setTimeout(() => {
        init();
    }, 1000);
</script>