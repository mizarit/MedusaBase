<?php


class JawboneOAuth {
    public static function authorize()
    {
        $keys = Registry::get('keys');

        $url = false;
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $url = 'https://jawbone.com/auth/oauth2/token?client_id='.Registry::get('client_id').'&client_secret='.Registry::get('app_secret').'&grant_type=authorization_code&code='.urlencode($code);
        }
        else if (isset($_GET['refresh'])) {
            if (isset($keys[Registry::get('jawbone_user_id')])) {
                $url = 'https://jawbone.com/auth/oauth2/token?client_id=' . Registry::get('client_id') . '&client_secret=' . Registry::get('app_secret') . '&grant_type=refresh_token&refresh_token=' . urlencode($keys[Registry::get('jawbone_user_id')]['refreshToken']);
            }
            else {
                $oauth_url = 'https://jawbone.com/auth/oauth2/auth?response_type=code&client_id='.Registry::get('client_id').'&scope='.urlencode('basic_read extended_read move_read weight_read sleep_read meal_read mood_read heartrate_read').'&redirect_uri='.urlencode('https://'.$_SERVER['SERVER_NAME'].'/main/oauth');
                header('Location: '.$oauth_url);
                exit;
            }
        }

        if ($url) {
            $content = file_get_contents($url);
            if ($content) {
                $token = json_decode($content);
                if (isset($token->error)) {
                    echo '<h2>'.$token->error.'</h2>';
                    echo '<p>'.$token->error_description.'/p>';
                    exit;
                }
                $keys[Registry::get('jawbone_user_id')]['accessToken'] = $token->access_token;
                $keys[Registry::get('jawbone_user_id')]['refreshToken'] = $token->refresh_token;
                $keys[Registry::get('jawbone_user_id')]['expires'] = $token->expires_in;

                file_put_contents('cache/keys.json', json_encode($keys));
                Registry::set('keys', $keys);

                header('Location: '.(isset($params['redirect']) ? $params['redirect'] : '/main/index?ju='.Registry::get('jawbone_user_id')));
                exit;
            }
        }
    }
}