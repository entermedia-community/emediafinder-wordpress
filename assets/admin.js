const emHost = 'https://emediafinder.com';
var workspaces;
var users = [];
var enabledUsers = [];

function init() {
    const emKey = document.getElementById('emdb_entermediakey');
    if (emKey && emKey.value) {
        GetWorkSpaces();
        const workspaceSelect = document.getElementById('emcatalogs');
    }
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

function HttpPost(url, data, async) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("POST", url, async);
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
    const resp = HttpPost(url + encodedEmail, {}, false);
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
    GetAdminKey();
}

function NoWorkspace() {
    const workspaceSelect = document.getElementById('catalogdropdown');
    const li = document.createElement('li');
    li.innerHTML = `<button class="dropdown-item" href="#" disabled>No Workspace found</button>`
    workspaceSelect.appendChild(li);
}

function GetWorkSpaces() {
    const block = document.getElementById('loadblock');
    block.style.display = "block";
    const message = document.getElementById('loading-message');
    message.innerHTML = 'Loading Your Workspace, Please wait...';

    var urlPath = "/entermediadb/mediadb/services/authentication/workspacesonteam.json";
    const emKey = document.getElementById('emdb_entermediakey');
    const encodedKey = encodeURIComponent(emKey.value);
    const url = encodeURI(`${emHost}${urlPath}?noredirect=true&entermedia.key=`); // dont re-encode email here
    const req = HttpPost(url + encodedKey, {}, true);
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
                    NoWorkspace();
                }
            } else {
                NoWorkspace();
            }
        }
    };
}

function GetAdminKey() {
    var urlPath = "/finder/mediadb/services/workspaces/getadminkey.json";
    const emKey = document.getElementById('emdb_entermediakey');
    const hostPrefix = document.getElementById('emdb_cdn_prefix').value;
    const encodedKey = encodeURIComponent(emKey.value);
    const collectionid = encodeURIComponent(document.getElementById('emdb_collectionid').value);
    const url = encodeURI(`${hostPrefix}${urlPath}`); // dont re-encode email here

    // TODO: get from api
    const req = HttpPost(`${url}?collectionid=${collectionid}&entermediacloudkey=${encodedKey}`, {}, true);
    req.onload = function () {
        if (req.readyState === 4) {
            if (req.status === 200) {
                var result = JSON.parse(req.response);
                console.log('gettingkey', result);
                if (result.response.status === 'ok') {
                    document.getElementById('emdb_adminkey').value = result.response.entermediakey;
                }
            } else {
                document.getElementById('adminkey_warning').innerHTML = 'Could not get key';
            }
        }
    }

}

setTimeout(() => { // give some time to wp to load vars
    init();
}, 1000);