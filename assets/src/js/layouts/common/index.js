(function ($) {
    class Common {
        constructor() {
            this.initializeCommon();
        }

        initializeCommon() {
            this.handleIsLogout();
        }

        handleIsLogout() {
            $('body').on('click', '.is-logout', function (e) {
                e.preventDefault()
                console.log('is-logout')
            });
        }

    }

    new Common();
})(jQuery);
