var emHost = '';
var workspaces;

function emediafinder_init() {
    const emKey = document.getElementById('emediafinderdb_entermediakey');
    const emMainServer = document.getElementById('emediafinderdb_main_server');
    if (!emMainServer.value) {
        emHost = 'https://emediafinder.com';
        emMainServer.value = emHost;
    } else {
        emHost = emMainServer.value
    }

    if (emKey && emKey.value && emHost) {
        emediafinder_GetWorkSpaces();
    }
    console.log(emHost);
}

if (!Array.prototype.find) {
    Object.defineProperty(Array.prototype, 'find', {
        enumerable: false,
        configurable: true,
        writable: true,
        value: function (predicate) {
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

function emediafinder_HttpPost(url, data, async) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("POST", url, async);
    xmlHttp.send(JSON.stringify(data));
    return xmlHttp;
}

function emediafinder_alertEmail(message, divid) {
    const alertDiv = document.getElementById(divid);
    alertDiv.style.display = "block";
    alertDiv.innerHTML = message;
    setTimeout(() => {
        alertDiv.style.display = "none";
    }, 5000);
}

function emediafinder_sendEmail() {
    const email = document.getElementById('emediafinderdb_email');
    if (!email.value) {
        emediafinder_alertEmail('Please type your email', 'alerterror');
        return;
    }
    const urlPath = '/entermediadb/mediadb/services/authentication/emailwordpress.json'
    const encodedEmail = encodeURIComponent(email.value);
    const url = encodeURI(`${emHost}${urlPath}?to=`); // dont re-encode email here
    const resp = emediafinder_HttpPost(url + encodedEmail, {}, false);
    if (resp.status === 200) {
        emediafinder_alertEmail('Email sent, please check your email don\'t forget to check spam folder', 'alertmail');
    } else {
        emediafinder_alertEmail('Please type a registered email', 'alerterror');
    }
}

function emediafinder_SelectWorkspace() {
    const selectCat = document.getElementById('emcatalogs');
    const workspace = workspaces.workspaces.find(x => x.url === selectCat.value);
    document.getElementById('emediafinderdb_cdn_prefix').value = workspace.url;
    document.getElementById('emediafinderdb_collectionid').value = workspace.collectionid;
    emediafinder_GetAdminKey();
}

function emediafinder_ConnectionError(msg) {
    const errorMessage = document.getElementById('workspacedanger');
    errorMessage.innerHTML = msg;
    errorMessage.style = "display: block";
}

function emediafinder_GetWorkSpaces() {
    const block = document.getElementById('loadblock');
    block.style.display = "block";
    const message = document.getElementById('loading-message');
    message.innerHTML = 'Loading Your Workspace, Please wait...';

    var urlPath = "/entermediadb/mediadb/services/authentication/workspacesonteam.json";
    const emKey = document.getElementById('emediafinderdb_entermediakey');
    const encodedKey = encodeURIComponent(emKey.value);
    const url = encodeURI(`${emHost}${urlPath}?noredirect=true&entermedia.key=`); // dont re-encode email here
    const req = emediafinder_HttpPost(url + encodedKey, {}, true);
    req.onload = function () {
        if (req.readyState === 4) {
            block.style.display = "none";
            if (req.status === 200) {
                workspaces = JSON.parse(req.response);
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
                    emediafinder_ConnectionError('Did not find any workspaces, please register and create new free trial instance');
                }
            } else {
                emediafinder_ConnectionError('Unable to Login, please refresh your key');
            }
        }
    };
}

function emediafinder_GetAdminKey() {
    var urlPath = "/finder/mediadb/services/workspaces/getadminkey.json";
    const emKey = document.getElementById('emediafinderdb_entermediakey');
    const hostPrefix = document.getElementById('emediafinderdb_cdn_prefix').value;
    const encodedKey = encodeURIComponent(emKey.value);
    const collectionid = encodeURIComponent(document.getElementById('emediafinderdb_collectionid').value);
    const url = encodeURI(`${hostPrefix}${urlPath}`); // dont re-encode email here

    const req = emediafinder_HttpPost(`${url}?collectionid=${collectionid}&entermediacloudkey=${encodedKey}`, {}, true);
    req.onload = function () {
        if (req.readyState === 4) {
            if (req.status === 200) {
                var result = JSON.parse(req.response);
                if (result.response.status === 'ok') {
                    document.getElementById('emediafinderdb_adminkey').value = result.response.entermediakey;
                }
            } else {
                document.getElementById('adminkey_warning').innerHTML = 'Could not get key';
            }
        }
    }
}

setTimeout(() => { // give some time to wp to load vars
    emediafinder_init();
}, 1000);