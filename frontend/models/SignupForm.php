<?php

namespace frontend\models;

use common\models\CommonFunctions;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $mobile;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['mobile', 'trim'],
            ['mobile', 'required'],
            ['mobile', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This mobile number has already been taken.'],
            ['mobile', 'string', 'min' => 2, 'max' => 20],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->mobile = $this->mobile;
        $user->email = $this->email;
        $user->password = $this->password;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->generateEmailVerificationToken();
        $user->save();
        CommonFunctions::sendEmail($user);
        return ["userData" => $user];
    }
}
