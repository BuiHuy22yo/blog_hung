(function ($) {
    class PostForum {
        constructor() {
            this.initializePost();
        }

        initializePost() {
            this.checkforum();
        }

        checkforum() {
            $('body').on('click', '.item-wrap', function (e) {
                e.preventDefault();
                $('input[type=checkbox]').prop("checked", false)
                $(this).find('input[type=checkbox]').prop("checked", !$(this).find('input[type=checkbox]').prop("checked"))

                let id_forum = $(this).find('input[type=checkbox]').val()
                let $current_page = 1
                console.log(id_forum)
                let data = {
                    'action': 'ctwp_ajax_get_topic_by_forum',
                    'id': id_forum,
                    'page': $current_page,
                };
                $.ajax({
                    url: ctwp_script.ajax_url,
                    data: data,
                    dataType: 'text',
                    type: 'POST',
                    beforeSend: function (xhr) {
                        $('.post-forum').addClass('loading');
                    },
                    success: function (data) {
						// $('.post-forum').removeClass('loading');
						setTimeout(function() {
							$('.inner-body').remove();
							$('body').find('.post-forum-topic').append(data)
						}, 500);
						$('body').scrollTop(0)
                    }
                });
            });
        }
    }

    new PostForum();
})(jQuery);
