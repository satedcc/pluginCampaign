$(document).ready(function() {
    $('#example').DataTable();
    $('#view').DataTable({
        pageLength: 25,
    });
    $("body").on("click", ".add", function() {
        event.preventDefault();
        $('[name=tags]').tagify();
        $(".formshow").slideToggle({});
    })
    $("body").on("click", ".edit", function() {
        var action = $(this).attr("data-value");
        var id = $(this).attr("href");
        event.preventDefault();
        $.ajax({
            url: "../wp-content/plugins/wecan/content/main.php",
            method: "POST",
            data: {
                id: id,
                action: action,
            },
            beforeSend: function() {
                $(".loading-bar").fadeIn().html("<div class='loader-dots'>Loading</div>");
            },
            success: function(data) {
                $(".formshow").slideDown();
                var x = data.split("||");
                if (action == "program") {
                    $(window).scrollTop($('#form-program').position().top);
                    $("#id").val(x[0]);
                    $("#nama").val(x[1]);
                    $("#target").val(x[2]);
                    $("#showimg").html(x[3]);
                    $("#mulai").val(x[4]);
                    $("#selesai").val(x[5]);
                    CKEDITOR.instances.desc.setData(x[6]);
                    $("#headline").val(x[7]);
                    $("#upload_image").val(x[8]);
                    $("#" + x[9]).prop("checked", true);
                    $("#btn-proses").text('Update Program');
                    $('[name=tags]').tagify();
                    $("#form-program").attr("action", "../wp-content/plugins/wecan/content/action.php?set=editprogram");
                } else if (action == "payment") {
                    $("#id").val(x[0]);
                    $("#kode").val(x[1]);
                    $("#nama").val(x[2]);
                    $("#pemilik").val(x[3]);
                    $("#norek").val(x[4]);
                    $("#biaya").val(x[5]);
                    $("#jenis").val(x[6]);
                    $("#aktif").val(x[7]);
                    $("#ket").val(x[8]);
                    $("#cara").val(x[9]);
                    $("#showimg").html(x[10]);
                    $("#btn").text('Update Payment');
                    $("#form-payment").attr("action", "../wp-content/plugins/wecan/content/action.php?set=editpayment");
                } else if (action == "kategori") {
                    $("#id").val(x[0]);
                    $("#nama").val(x[1]);
                    $("#aktif").val(x[2]);
                    $("#icon").val(x[3]);
                    $("#showimg").html(x[4]);
                    $("#upload_image").val(x[5]);
                    $("#btn").text('Update Kategori');
                    $("form").attr("action", "../wp-content/plugins/wecan/content/action.php?set=editkategori");
                }
            },
        });
    });
    CKEDITOR.replace('desc', {
        height: 300
    });
    $("body").on("click", ".view-order", function() {
        event.preventDefault();
        var id = $(this).attr("href");
        $.ajax({
            url: "../wp-content/plugins/wecan/content/detaildonasi.php",
            type: "POST",
            data: {
                id: id
            },
            beforeSend: function() {

            },
            success: function(data) {
                $(".bg-overplay,.modal").fadeToggle();
                $("#viewdonasi").html(data)
            },
        });
    });
    $("body").on("click", ".view-program", function() {
        event.preventDefault();
        var id = $(this).attr("href");
        $.ajax({
            url: "../wp-content/plugins/wecan/content/detailprogram.php",
            type: "POST",
            data: {
                id: id
            },
            beforeSend: function() {

            },
            success: function(data) {
                $(".bg-overplay,.modal").fadeToggle();
                $("#viewdonasi").html(data)
            },
        });
    });
    $("body").on("submit", "#form-program", function(e) {
        e.preventDefault();
        var url = $(this).attr("action");
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $("#btn-proses").text("Loading...");
            },
            success: function(data) {
                $("body").append(`<div class="info">
                                <div class="info-body">
                                    Program Donasi berhasil tersimpan
                                </div>
                            </div>`);
                $(".info").delay("3000").fadeOut("3000");
                setTimeout(function() {
                    window.location.reload(1);
                }, 3000);
                $("#btn-proses").text("Simpan");
            },
        });
    });
    $("body").on("click", ".show-icon a", function(e) {
        e.preventDefault();
        let icon = $(this).attr("href");
        $("#icon").val(icon)

    });
    $("body").on("click", "#icon", function(e) {
        $(".show-icon").fadeToggle();

    });
    $("body").on("submit", "#formwa", function(e) {
        e.preventDefault();
        var url = $(this).attr("action");
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $("#wa-send").text("Loading...");
            },
            success: function(data) {
                $("body").append(`<div class="info">
                                <div class="info-body">
                                    ` + data + `
                                </div>
                            </div>`);
                $(".info").delay("3000").fadeOut("100000");
                $("#wa-send").text("Test Whatsapp");
            },
        });
    });
    // UPLOADER
    var custom_uploader;


    $('#upload_image_button').click(function(e) {

        e.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            console.log(custom_uploader.state().get('selection').toJSON());
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#upload_image').val(attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();

    });
});
$(document).on('click', function(e) {
    if ($(e.target).closest(".modal").length === 0) {
        $(".modal").fadeOut();
        $(".bg-overplay").fadeOut();
    }
});