<?php

class ChallengeUser extends Base {
  public $model = 'challenge_user';

  public $relations = array(
    'user' => 'user_id',
    'challenge' => 'challenge_id',
  );

  public static function model()
  {
    return new ChallengeUser;
  }
}