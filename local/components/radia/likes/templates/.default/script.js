window.initLikes = function () {
    $('a.like').off('click').on('click', function (e) {
        var el = $(this)
        var num = parseInt(el.find('span').text(), 10) - ($(this).hasClass('like--liked') ? 1 : -1)
        el.find('span').text(num)
        el.toggleClass('like--liked')
        el.addClass('like--innactive')
        $.get('/local/components/radia/likes/change.php', { id: $(this).data('id') }, function (data) {
            el.removeClass('like--innactive')
        })
        e.preventDefault()
    })
}

$(function () {
    window.initLikes()
})
