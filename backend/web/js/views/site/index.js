$(function () {
    $(document).on('click', '.js-generate-apples', function (e) {
        e.preventDefault();

        const $btn = $(this);
        const url = $btn.data('url');

        $btn.prop('disabled', true).addClass('disabled');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'html',
        })
        .done(function (html) {
            $('.js-apples-list').html(html);
        })
        .fail(function (xhr) {
            console.error(xhr.responseText || xhr.statusText);
            alert('Не удалось сгенерировать яблоки.');
        })
        .always(function () {
            $btn.prop('disabled', false).removeClass('disabled');
        });
    });
});
