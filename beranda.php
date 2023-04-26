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

<div class="breadcumb" style="margin-top: 10px;">
    <i class="far fa-home"></i> Admin > List Campaign
</div>
<?php if (isset($_GET['action'])) : ?>
    <div class="card-default" style="margin:auto;width: 70%;">
        <div class="card-header m-0">
            <span class="subs m-0">Create List Campaign</span>
        </div>
        <div class="row">
            <div class="col">
                <form action="" method="post">
                    <input type="hidden" name="action" value="list">
                    <div class="form-group">
                        <label for="">Name</label>
                        <div class="input-text">
                            <input type="text" placeholder="name" name="name" id="name" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">String ID</label>
                        <div class="input-text">
                            <input type="text" placeholder="string" name="string" id="string" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Sender URL</label>
                        <div class="input-text">
                            <input type="text" placeholder="sender" name="sender" id="sender" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Sender Reminder</label>
                        <div class="input-text">
                            <input type="text" placeholder="reminder" name="reminder" id="reminder" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">User</label>
                        <div class="input-text">
                            <input type="text" placeholder="user" name="user" id="user" required>
                        </div>
                    </div>
                    <button class="btn btn-main">Create List</button>
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
<?php else : ?>
    <div class="card-header m-0">
        <span class="subs m-0">Program/Campaign</span>
        <div>
            <a href="admin.php?page=beranda&action=createlist" class="btn btn-main"><i class="far fa-layer-plus"></i> Create List</a>
        </div>
    </div>
    <div class="card-default">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>stringid</th>
                    <th>userid</th>
                    <th>name</th>
                    <th>cdate</th>
                    <th>sender_url</th>
                    <th>sender_reminder</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($res['lists'] as $l) {
                    echo '<tr>
                        <td>' . $no++ . '</td>
                        <td>' . $l['stringid'] . '</td>
                        <td>' . $l['userid'] . '</td>
                        <td>' . $l['name'] . '</td>
                        <td>' . $l['cdate'] . '</td>
                        <td>' . $l['sender_url'] . '</td>
                        <td>' . $l['sender_reminder'] . '</td>
                        <td><a href="../wp-content/plugins/activecampaign/customquery.php?action=delete_list&id=' . $l['id'] . '">Delete</a></td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>