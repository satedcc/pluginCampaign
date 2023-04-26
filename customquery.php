<?php
include('../../../wp-load.php');
$table_prefix = $wpdb->prefix . "api";
$c = $wpdb->get_row("SELECT * FROM $table_prefix WHERE id = 1");
if (isset($_POST['action'])) {
    if ($_POST['action'] == "post_api") {
        $post_api = $wpdb->query("UPDATE $table_prefix SET url='$_POST[url]',api_token='$_POST[token]' WHERE id='1'");
        if ($post_api) {
            echo '<div class="alert alert-success">
                    Update URL dan Token Berhasil
                </div>';
        } else {
            echo '<div class="alert alert-danger">
                    Update URL dan Token Gagal
                </div>';
        }
    } elseif ($_POST['action'] == "list") {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $c->url . 'api/3/lists',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "list": {
                    "name": "' . $_POST['name'] . '",
                    "stringid": "' . $_POST['string'] . '",
                    "sender_url": "' . $_POST['sender'] . '",
                    "sender_reminder": "' . $_POST['reminder'] . '",
                    "user": "' . $_POST['user'] . '"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Api-Token: ' . $c->api_token . '',
                'Content-Type: text/plain',
                'Cookie: PHPSESSID=e6f12c60964625aa1f98fe85824e145d; em_acp_globalauth_cookie=4bea6c40-2f03-45c5-8d9a-a94704c6f33c'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    } elseif ($_POST['action'] == "subscribe") {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $c->url . 'api/3/contacts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "contact": {
                "email": "' . $_POST['email'] . '",
                "firstName": "' . $_POST['first_name'] . '",
                "lastName": "' . $_POST['last_name'] . '",
                "phone": ""
            }
        }',
            CURLOPT_HTTPHEADER => array(
                'Api-Token: ' . $c->api_token . '',
                'Content-Type: application/json',
                'Cookie: PHPSESSID=e6f12c60964625aa1f98fe85824e145d; em_acp_globalauth_cookie=51e08d5b-35a4-4f00-ae25-b31053a0e4eb'
            ),
        ));

        $response = curl_exec($curl);
        $res = json_decode($response, true);
        curl_close($curl);
        if (isset($res['errors'])) {
            echo 'Email address already exists in the system';
        } else {
            echo 'Email hass been successfully';
            // echo $res['contact']['id'];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $c->url . 'api/3/contactLists',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "contactList": {
                        "list": ' . $_POST['campaign'] . ',
                        "contact": ' . $res['contact']['id'] . ',
                        "status": 1
                    }
                }',
                CURLOPT_HTTPHEADER => array(
                    'Api-Token: ' . $c->api_token . '',
                    'Content-Type: text/plain',
                    'Cookie: PHPSESSID=e6f12c60964625aa1f98fe85824e145d; em_acp_globalauth_cookie=6a20ac93-09ed-432a-856c-0baffeda07c8'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
        }
        // var_dump($res);
    }
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == "delete_list") {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $c->url . 'api/3/lists/' . $_GET['id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Api-Token: ' . $c->api_token . '',
                'Cookie: PHPSESSID=e6f12c60964625aa1f98fe85824e145d; em_acp_globalauth_cookie=c4cf79b3-c3d3-4795-9746-db2081014742'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
