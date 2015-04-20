<?php

class Team extends Base {
  public $model = 'team';

  public $relations = array(
    'challenge' => 'challenge_id',
  );

  public static function model()
  {
    return new Team;
  }
}