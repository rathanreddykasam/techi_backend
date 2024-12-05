<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_comments".
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $comment
 * @property int|null $like
 * @property int|null $view
 *
 * @property UserPosts $post
 * @property User $user
 */
class PostComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id', 'comment'], 'required'],
            [['user_id', 'post_id', 'like', 'view'], 'integer'],
            [['comment'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::class, 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'post_id' => 'Post ID',
            'comment' => 'Comment',
            'like' => 'Like',
            'view' => 'View',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::class, ['id' => 'post_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
