<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class CommonFunctions extends Model
{

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    public static function sendEmail($data)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $data]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($data->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
