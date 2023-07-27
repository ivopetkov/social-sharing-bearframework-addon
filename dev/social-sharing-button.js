
var ivoPetkov = ivoPetkov || {};
ivoPetkov.bearFrameworkAddons = ivoPetkov.bearFrameworkAddons || {};
ivoPetkov.bearFrameworkAddons.socialSharingButton = ivoPetkov.bearFrameworkAddons.socialSharingButton || (function () {

    var resultCache = null;

    var open = function (url) {
        console.log(url);
        if (typeof url === 'undefined' || url === null || url === '') {
            url = window.location.href.toString();
        }
        clientPackages.get('lightbox').then(function (lightbox) {
            var context = lightbox.make();
            var open = function () {
                context.open(resultCache.split('{encodedurl}').join(encodeURIComponent(url)), {
                    onOpen: function () {
                        var copyButton = document.querySelector('[data-ipssb="c"]');
                        if (typeof navigator.clipboard !== 'undefined' && navigator.clipboard.writeText !== 'undefined') {
                            copyButton.addEventListener('click', function () {
                                navigator.clipboard.writeText(url)
                                    .then(function () {
                                        copyButton.innerText = copyButton.getAttribute('data-ipsssbt');
                                    })
                                    .catch(function () {
                                        alert("Error occured!");
                                    });
                            });
                        } else {
                            copyButton.style.display = 'none';
                        }

                        var otherButton = document.querySelector('[data-ipssb="o"]');
                        if (typeof navigator.share !== 'undefined') {
                            otherButton.addEventListener('click', function () {
                                navigator.share({ url: url })
                                    .then(function () {
                                    })
                                    .catch(function () {
                                        alert("Error occured!");
                                    });
                            });
                        } else {
                            otherButton.style.display = 'none';
                        }
                    }
                });
            };
            if (resultCache !== null) {
                open();
            } else {
                clientPackages.get('serverRequests').then(function (serverRequests) {
                    serverRequests.send('-ivopetkov-social-sharing-get-window').then(function (responseText) {
                        var result = JSON.parse(responseText);
                        if (typeof result.html !== 'undefined') {
                            resultCache = result.html;
                            open();
                        }
                    });
                });
            }
        });
    };

    return {
        'open': open
    };

}());