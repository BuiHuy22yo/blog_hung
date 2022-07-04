(function ($) {
    function funcLoadComment() {
        let id_topic = $('body').find('#id_topic').val()
        if (!id_topic) {
            return
        }
        let data = {
            'action': 'ctwp_ajax_Load_comment',
            'id_topic': id_topic
        };
        $.ajax({
            url: ctwp_script.ajax_url,
            data: data,
            dataType: 'text',
            type: 'POST',
            beforeSend: function (xhr) {
                // $('.post-forum').addClass('loading');
            },
            success: function (data) {
                // $('.post-forum').removeClass('loading');
                $('.inner-item').remove();
                $('body').find('.topic-comments').append(data)
            }
        });
    }

    function funcGetPost(id_forum = undefined, $current_page = 1) {
        if (!id_forum) {
            return;
        }
        let data = {
            'action': 'ctwp_ajax_get_topic_by_forum',
            'id': id_forum,
            'page': $current_page,
        };
        $.ajax({
            url: ctwp_script.ajax_url,
            data: data,
            dataType: 'json',
            type: 'POST',
            beforeSend: function (xhr) {
                $('.post-forum').addClass('loading');
            },
            success: function (data) {
                // $('.post-forum').removeClass('loading');
                console.log(data.data)
                if (!data) {
                    return;
                }
                if (data.post) {
                    setTimeout(function () {
                        $('.inner-body').remove();
                        $('body').find('.post-forum-topic').append(data.post)
                    }, 500);
                }
                if (data.pagination) {
                    setTimeout(function () {
                        $('.pagination').remove();
                        $('body').find('.archive-post-pagination').append(data.pagination)
                    }, 500);
                }
                $('body').scrollTop(0)
            }
        });
    }

    class PostForum {
        constructor() {
            this.initializePost();
        }

        initializePost() {
            this.TopicByForum();
            this.handleComment();
            this.handleAddComment();
            this.handleReplyComment();
            this.TopicPagination();
        }

        TopicByForum() {
            $('body').on('click', '.item-wrap', function (e) {
                e.preventDefault();
                $('input[type=checkbox]').prop("checked", false)
                $(this).find('input[type=checkbox]').prop("checked", !$(this).find('input[type=checkbox]').prop("checked"))

                let id_forum = $(this).find('input[type=checkbox]').val()
                let $current_page = 1
                if (!id_forum) {
                    return;
                }
                funcGetPost(id_forum, $current_page)
            });
        }


        TopicPagination() {
            $('body').on('click', '.page-item', function (e) {
                let id_forum = $('.item-wrap').find('input[type=checkbox]:checked').val()
                let next_page = $(this).find('#next_page').val()
                funcGetPost(id_forum, next_page)
            });
        }

        handleComment() {
            $('body').on('click', '.button-comment', function (e) {
                e.preventDefault();
                funcLoadComment()
            });
        }

        handleAddComment() {
            $('body').on('click', '.add-comment', function (e) {
                e.preventDefault();
                let button = $(this);
                let content = button.parent().find('#content').val()
                let id_user = $('body').find('#id_user').val()
                let id_topic = $('body').find('#id_topic').val()
                let id_reply = $(this).find('#id_reply').val()
                if (!content || !id_user || !id_topic) {
                    return
                }
                let data = {
                    'action': 'ctwp_ajax_create_comment',
                    'id': id_user,
                    'content': content,
                    'id_topic': id_topic,
                    'id_reply': id_reply
                };
                $.ajax({
                    url: ctwp_script.ajax_url,
                    data: data,
                    dataType: 'text',
                    type: 'POST',
                    beforeSend: function (xhr) {
                        // $('.post-forum').addClass('loading');
                    },
                    success: function (data) {
                        // $('.post-forum').removeClass('loading');
                        button.parent().find('#content').val('')
                        console.log('sucsess ', data)
                    }
                });
                setTimeout(function () {
                    funcLoadComment()
                }, 500);
            });
        }

        handleReplyComment() {
            $('body').on('click', '.button-reply', function (e) {
                e.preventDefault();
                let button = $(this)
                let action_add = button.parent().parent().find(".topic-add-comment")
                action_add.addClass('d-flex')
                action_add.removeClass('d-none')

            });
        }
    }

    new PostForum();
})(jQuery);
