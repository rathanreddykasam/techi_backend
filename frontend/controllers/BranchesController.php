<?php

namespace frontend\controllers;

use common\models\Branches;
use yii\rest\ActiveController;

class UserPostsController extends ActiveController
{
    public $modelClass = Branches::class;

}