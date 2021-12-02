(function () {
    var element = document.getElementById('ELEMENTID_TO_REPLACE');
    var url = 'URL_TO_REPLACE';
    if (url.length === 0) {
        url = window.location.href.toString();
    }
    element.addEventListener('click', function () {
        clientPackages.get('lightbox').then(function (lightbox) {
            var context = lightbox.make();
            var open = function () {
                context.open(window.ssbwindowhtml.split('{encodedurl}').join(encodeURIComponent(url)));
            };
            if (typeof window.ssbwindowhtml !== 'undefined') {
                open();
            } else {
                clientPackages.get('serverRequests').then(function (serverRequests) {
                    serverRequests.send('-ivopetkov-social-sharing-get-window').then(function (responseText) {
                        var result = JSON.parse(responseText);
                        if (typeof result.html !== 'undefined') {
                            window.ssbwindowhtml = result.html;
                            open();
                        }
                    });
                });
            }
        });
    });
})();