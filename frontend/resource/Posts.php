<?php

namespace frontend\resource;

namespace yii;

namespace common\models\Posts;

class Posts extends Posts
{

    public function fields()
    {
        // If this is an individual view (e.g., /posts/123), return all attributes
        // if (Posts::$app->controller->action->id === 'view') {
        //     return parent::fields(); // Return all fields
        // }

        // For index (e.g., /posts), return only specific fields
        return ['id', 'post_id', 'user_id', 'Intro', 'logo', 'banner', 'heading', 'tagline'];
    }
}
