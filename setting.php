<?php
global $wpdb;
$table_prefix = $wpdb->prefix . "api";
$c = $wpdb->get_row("SELECT * FROM $table_prefix WHERE id = 1");
?>
<div class="breadcumb" style="margin-top: 10px;">
    <i class="far fa-home"></i> Admin > Setting API
</div>
<div class="card-default" style="margin:auto;width: 70%;">
    <div class="card-header m-0">
        <span class="subs m-0">Program/Campaign</span>
    </div>
    <div class="row">
        <div class="col">
            <form action="" method="post">
                <input type="hidden" name="action" value="post_api">
                <div class="form-group">
                    <label for="">URL</label>
                    <div class="input-text">
                        <input type="text" placeholder="url" name="url" id="url" required autofocus value="<?= $c->url ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Token Key</label>
                    <div class="input-text">
                        <input type="text" placeholder="token" name="token" id="token" required value="<?= $c->api_token ?>">
                    </div>
                </div>
                <button class="btn btn-main">Update</button>
                <button class="btn btn-warning">Test Koneksi</button>
            </form>
            <div id="info"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "../wp-content/plugins/activecampaign/customquery.php",
                data: $(this).serialize(),
                beforeSend: function() {
                    $(".btn-main").text('Loading....')
                },
                success: function(response) {
                    $(".btn-main").text('Update')
                    $("#info").html(response)
                }
            });
        });
    });
</script>