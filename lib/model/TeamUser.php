<?php

class TeamUser extends Base {
  public $model = 'team_user';

  public $relations = array(
    'user' => 'user_id',
    'team' => 'team_id',
  );

  public static function model()
  {
    return new TeamUser;
  }
}