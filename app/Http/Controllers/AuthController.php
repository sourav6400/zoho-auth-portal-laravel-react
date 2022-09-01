<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function test(Request $req)
    {
        $code = $req->code;
        $REDIRECT_URI_MAIN = $req->redirect_uri;
        // $REDIRECT_URI = urlencode($REDIRECT_URI_MAIN);
        $REDIRECT_URI = $req->redirect_uri;
        $CLIENT_ID = $req->client_id;
        $CLIENT_SECRET = $req->client_secret;
        $SCOPES = env('ZOHO_CURRENT_USER_SCOPES');

        if ($code != null) {
            $POSTFIELDS = 'code=' . $code . '&redirect_uri=' . $REDIRECT_URI . '&client_id=' . $CLIENT_ID . '&client_secret=' . $CLIENT_SECRET . '&grant_type=authorization_code';

            $json_response = $this->curlRequest($POSTFIELDS);
            $response = json_decode($json_response, true);

            if (isset($response['error']) && $response['error'] == 'invalid_code') {
                return redirect()->to($REDIRECT_URI_MAIN);
            } elseif (isset($response['refresh_token'])) {
                $refresh_toke = $response['refresh_token'];

                $data = [
                    "redirect_uri" => $REDIRECT_URI,
                    "client_id" => $CLIENT_ID,
                    "client_secret" => $CLIENT_SECRET,
                    "refresh_token" => $refresh_toke
                ];

                Storage::disk('public')->put($CLIENT_ID . '.json', json_encode($data));
                return $json_response;
            }
        } else {
            $auth_file = Storage::disk('public')->get($CLIENT_ID . '.json');

            if ($auth_file != null) {
                $auth_file = json_decode($auth_file, true);

                if (isset($auth_file['redirect_uri']) && isset($auth_file['client_id']) && isset($auth_file['client_secret'])) {
                    if ($REDIRECT_URI == $auth_file['redirect_uri'] && $CLIENT_ID == $auth_file['client_id'] && $CLIENT_SECRET == $auth_file['client_secret']) {
                        $refresh_token = $auth_file['refresh_token'];

                        $POSTFIELDS = 'refresh_token=' . $refresh_token . '&client_id=' . $CLIENT_ID . '&client_secret=' . $CLIENT_SECRET . '&grant_type=refresh_token';

                        return $this->curlRequest($POSTFIELDS);
                    }
                } else {
                    $url = "https://accounts.zoho.com/oauth/v2/auth?scope=" . $SCOPES . "&client_id=" . $CLIENT_ID . "&response_type=code&access_type=offline&redirect_uri=" . $REDIRECT_URI;
                    return redirect()->to($url);
                }
            } else {
                $url = "https://accounts.zoho.com/oauth/v2/auth?scope=" . $SCOPES . "&client_id=" . $CLIENT_ID . "&response_type=code&access_type=offline&redirect_uri=" . $REDIRECT_URI;
                return $url;
            }
        }
    }

    public function curlRequest($POSTFIELDS)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $POSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function index(Request $request)
    {
        $code = $request->get('code');
        $REDIRECT_URI_MAIN = env('ZOHO_REDIRECT_URI');
        $REDIRECT_URI = urlencode($REDIRECT_URI_MAIN);
        $CLIENT_ID = env('ZOHO_CLIENT_ID');
        $CLIENT_SECRET = env('ZOHO_CLIENT_SECRET');
        $SCOPES = env('ZOHO_CURRENT_USER_SCOPES');

        if ($code != null) {
            $POSTFIELDS = 'code=' . $code . '&redirect_uri=' . $REDIRECT_URI . '&client_id=' . $CLIENT_ID . '&client_secret=' . $CLIENT_SECRET . '&grant_type=authorization_code';

            $json_response = $this->curlRequest($POSTFIELDS);
            $response = json_decode($json_response, true);

            if (isset($response['error']) && $response['error'] == 'invalid_code') {
                return redirect()->to($REDIRECT_URI_MAIN);
            } elseif (isset($response['refresh_token'])) {
                $refresh_toke = $response['refresh_token'];

                $data = [
                    "redirect_uri" => $REDIRECT_URI,
                    "client_id" => $CLIENT_ID,
                    "client_secret" => $CLIENT_SECRET,
                    "refresh_token" => $refresh_toke
                ];

                Storage::disk('public')->put($CLIENT_ID . '.json', json_encode($data));
                return $json_response;
            }
        } else {
            $auth_file = Storage::disk('public')->get($CLIENT_ID . '.json');

            if ($auth_file != null) {
                $auth_file = json_decode($auth_file, true);

                if (isset($auth_file['redirect_uri']) && isset($auth_file['client_id']) && isset($auth_file['client_secret'])) {
                    if ($REDIRECT_URI == $auth_file['redirect_uri'] && $CLIENT_ID == $auth_file['client_id'] && $CLIENT_SECRET == $auth_file['client_secret']) {
                        $refresh_token = $auth_file['refresh_token'];

                        $POSTFIELDS = 'refresh_token=' . $refresh_token . '&client_id=' . $CLIENT_ID . '&client_secret=' . $CLIENT_SECRET . '&grant_type=refresh_token';

                        return $this->curlRequest($POSTFIELDS);
                    }
                } else {
                    $url = "https://accounts.zoho.com/oauth/v2/auth?scope=" . $SCOPES . "&client_id=" . $CLIENT_ID . "&response_type=code&access_type=offline&redirect_uri=" . $REDIRECT_URI;
                    return redirect()->to($url);
                }
            } else {
                $url = "https://accounts.zoho.com/oauth/v2/auth?scope=" . $SCOPES . "&client_id=" . $CLIENT_ID . "&response_type=code&access_type=offline&redirect_uri=" . $REDIRECT_URI;
                return redirect()->to($url);
            }
        }
    }
}
