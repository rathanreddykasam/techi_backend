<?php

namespace frontend\controllers;

use Yii;
use yii\rest\Controller;
use common\models\LoginForm;
use common\models\User;
use frontend\models\SignupForm;
use yii\filters\ContentNegotiator;

class ApiController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    /**
     * Login action for API.
     * @return array
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        // Load data from POST request
        $model->load(Yii::$app->request->post(), '');

        if ($model->login()) {
            $user = Yii::$app->user->identity;
            return [
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'accessToken' => $user->access_token
                ],
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Invalid login credentials',
                'errors' => $model->errors,
            ];
        }
    }

    /**
     * Signup API action.
     * @return array
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $model->load(Yii::$app->request->post(), '');
        if ($user = $model->signup()) {

            //$user = Yii::$app->user->identity;
            return [
                'status' => 'success',
                'message' => 'Signup successful',
                'data' => [
                    'user_id' => $user['userData']->id,
                    'username' => $user['userData']->username,
                    'email' => $$user['userData']->email,
                    'accessToken' => $$user['userData']->access_token
                ],
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Signup failed',
                'errors' => $model->errors,
            ];
        }
    }

    public function actionLogout()
    {

        $post_data = Yii::$app->request->post();
        $user = User::findOne($post_data['user_id']);
        $user->access_token = "";
        $user->save();
        return [
            'status' => 'success',
            'message' => 'User successfully logout'
        ];
    }
}
