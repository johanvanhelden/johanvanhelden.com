(function(App) {
    'use strict';

    App.onDomReady = function() {
        App.initLogout();
        App.initDelete();
    };

    /**
     * Deletes elements by class, triggered by a click.
     */
    App.initDelete = function() {
        var deleteButtons = document.getElementsByClassName('js-delete');

        Array.from(deleteButtons).forEach(function(button) {
            button.addEventListener('click', function() {
                var targetClass = this.getAttribute('data-target');
                var targetElement = document.getElementsByClassName(targetClass);

                targetElement[0].remove();
            });
        });
    };

    /**
     * Initializes the logout.
     */
    App.initLogout = function() {
        var logoutTriggers = document.getElementsByClassName('js-logout-trigger');

        Array.from(logoutTriggers).forEach(element => {
            element.addEventListener('click', event => {
                event.preventDefault();

                document.getElementById('js-logout-form').submit();
            });
        });
    };
})((window.App = window.App || {}));

document.addEventListener('DOMContentLoaded', App.onDomReady);
