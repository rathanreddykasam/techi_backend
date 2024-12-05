<?php

namespace frontend\controllers;

use frontend\resource\User;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = User::class;
}
