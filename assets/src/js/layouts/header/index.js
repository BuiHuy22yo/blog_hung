(function ($) {
	class Header {
		constructor() {
			this.initializeHeader();
		}

		initializeHeader() {
			// this.fixScroll();
			this.mobile();
			this.language();
			this.menucateshowct();
		}

		fixScroll() {
			var header = new Headroom(document.querySelector(".cct-header"), {
				tolerance: 5,
				offset: 205,
				classes: {
					initial: "animated",
					pinned: "slideDown",
					unpinned: "slideUp"
				}
			});
			header.init();
		}

		mobile() {
			$('#dl-menu').dlmenu({
				animationClasses: {classin: 'dl-animate-in-5', classout: 'dl-animate-out-5'}
			});
		}

		language() {
			$('#handleChangeLanguage').on('click', function (e) {
				$('.add_class_active_lg').toggleClass('active');
			});
		}
		menucateshowct() {
			$('.header-cate-menu').on('click', function (e) {
				$('.show-cate-main-custom').toggleClass('active');
			});
		}
	}

	new Header();
})(jQuery);