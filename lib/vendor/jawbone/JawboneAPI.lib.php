<?php

class JawboneAPI {
  public static function api_call($api, $jawbone_user, $skip_error_check = false)
  {
    static $users = array();
    if (!isset($users[$jawbone_user])) {
      $user = User::model()->findByAttributes(new Criteria(array('xid' => $jawbone_user)));
      $users[$jawbone_user] = $user;
    }

    $user = $users[$jawbone_user];

    $cache = Cache::model()->findByAttributes(new Criteria(array(
      'xid' => $jawbone_user,
      'api' => $api
    )));
    if ($cache) {
      if (strtotime($cache->created_at) > strtotime('-5 minutes')) {
        return json_decode($cache->output);
      }
    }
    else {
      $cache = new Cache;
      $cache->xid = $jawbone_user;
      $cache->api = $api;
    }

    $url = 'https://jawbone.com/nudge/api/v.1.1/users/@me'.$api;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer ".$user->accessToken
    ));

    $output = json_decode(curl_exec($curl));
    if (isset($output->meta->error_type)) {
      $url = 'https://jawbone.com/auth/oauth2/token?client_id='.Registry::get('client_id').'&client_secret='.Registry::get('app_secret').'&grant_type=refresh_token&refresh_token='.$user->refreshToken;
      $content = file_get_contents($url);
      if ($content) {
        $token = json_decode($content);
        if (isset($token->error)) {
          if(!$skip_error_check) {
            setcookie('xid_id', null, strtotime('-1 year'), '/');
            header('Location: /main/index');
            exit;
          }
          else {
            //echo $user->accessToken."<br>\n";
            return false;
          }
        } else {
          $user->accessToken = $token->access_token;
          $user->refreshToken = $token->refresh_token;
          $user->expires = $token->expires_in;
          $user->save();
          return self::api_call($api, $jawbone_user);
        }
      }
    }

    $cache->output = json_encode($output);
    $cache->created_at = date('Y-m-d H:i:s');
    $cache->save();

    return $output;
  }

}