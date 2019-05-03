$(document).ready(function () {
    $(document).on('click', '.btnEditBanner', function() {
        let $this = $(this);
        $.ajax({
            url: ebook.base_url + '/admin/banner/' + $(this).data('id'),
            type: 'get',
            dataType: 'json',
        })
        .done(function(rs) {
            $($this.data('target')).find('#banner-name').val(rs.name);
            $($this.data('target')).find('#banner-url').val(rs.url);
            $($this.data('target')).find('#avatar').attr('src', ebook.base_url + '/upload/banners/' + rs.image);
        })
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('div.alert').delay(3000).slideUp();

    $(function () {
        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(id).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('form').on('change', '#avatar_file', function () {
            readURL(this, '#avatar');
        });

        $('form').on('change', '#cover_image', function () {
            readURL(this, '#cover_image');
        });
    });
});