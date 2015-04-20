<?php

class Challenge extends Base {
  public $model = 'challenge';

  public $relations = array(
  );

  public static function model()
  {
    return new Challenge;
  }
}