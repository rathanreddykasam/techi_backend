<?php

namespace frontend\controllers;

use common\models\UserPosts;
use yii\rest\ActiveController;

class UserPostsController extends ActiveController
{
    public $modelClass = UserPosts::class;

}