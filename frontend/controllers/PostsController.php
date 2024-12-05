<?php

namespace frontend\controllers;

use common\models\Posts;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\UploadedFile;
use yii;
use yii\filters\Cors;

class PostsController extends ActiveController
{
    public $modelClass = Posts::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    // public function behaviors()
    // {
    //     $behaviors = parent::behaviors();

    //     $behaviors['authenticator']['only'] = ['view', 'index', 'create', 'update', 'delete'];
    //     $behaviors['authenticator']['authMethods'] = [
    //         HttpBearerAuth::class
    //     ];

    //     return $behaviors;
    // }

    public function actionCreate()
    {
        $model = new Posts();

        // Load data from POST
        $model->load(Yii::$app->request->post(), '');

        // Load files from request
        $bannerFile = UploadedFile::getInstanceByName('bannerFile');
        $logoFile = UploadedFile::getInstanceByName('logoFile');

        $uploadPath = Yii::getAlias('@frontend/web/images/');

        if ($bannerFile) {
            $bannerFilename = uniqid('banner_') . '.' . $bannerFile->extension;
            $bannerFile->saveAs($uploadPath . $bannerFilename);
            $model->banner = $bannerFilename;
        }

        if ($logoFile) {
            $logoFilename = uniqid('logo_') . '.' . $logoFile->extension;
            $logoFile->saveAs($uploadPath . $logoFilename);
            $model->logo = $logoFilename;
        }


        // Save uploaded files and then save the model
        if ($model->save()) {
            return [
                'status' => 'success',
                'data' => $model,
            ];
        }

        return [
            'status' => 'error',
            'errors' => $model->errors,
        ];
    }
}
