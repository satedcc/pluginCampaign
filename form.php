<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://satedcc.api-us1.com/api/3/lists?limit=25',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Api-Token: ca62d6b4c804db434705c4e1f308870a1c99ace71ddd7b3510eccbf6356729f0ed47f964',
        'Cookie: PHPSESSID=e6f12c60964625aa1f98fe85824e145d; em_acp_globalauth_cookie=c9648c96-f86b-43df-919a-6f61241d6a7d'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
$res = json_decode($response, true);

?>

<form action="" method="post">
    <input type="hidden" name="action" value="subscribe">
    <div style="margin-bottom: 10px;">
        <label for="">List Campaign</label>
        <select name="campaign" id="campaign" style="display: block;width: 100%;">
            <?php
            foreach ($res['lists'] as $l) {
                echo '<option value="' . $l['id'] . '">' . $l['name'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div style="margin-bottom: 10px;">
        <label for="">First Name</label>
        <input type="text" name="first_name" placeholder="first_name" autofocus>
    </div>
    <div style="margin-bottom: 10px;">
        <label for="">Last Name</label>
        <input type="text" name="last_name" placeholder="last_name">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="">Email</label>
        <input type="text" name="email" placeholder="hello@email.com">
    </div>
    <div>
        <button id="btn-subs">Subscribe Now</button>
    </div>
    <div id="info"></div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?= get_site_url() ?>/wp-content/plugins/activecampaign/customquery.php",
                data: $(this).serialize(),
                beforeSend: function(response) {
                    $("#btn-subs").text('Loading....')
                },
                success: function(response) {
                    $("#info").html(response)
                    $("#btn-subs").text('Subscribe Successfully');
                    setTimeout(() => {
                        $("#btn-subs").text('Subscribe Now');
                    }, 4000);
                }
            });
        });
    });
</script>