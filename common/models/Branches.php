<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%branches}}".
 *
 * @property int $id
 * @property string $branch_name
 * @property int $status
 * @property string $created_on
 *
 * @property Category[] $categories
 * @property UserPosts[] $userPosts
 */
class Branches extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%branches}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_name', 'status'], 'required'],
            [['status'], 'integer'],
            [['created_on'], 'safe'],
            [['branch_name'], 'string', 'max' => 51],
            [['branch_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branch_name' => 'Branch Name',
            'status' => 'Status',
            'created_on' => 'Created On',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CategoryQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['branch_id' => 'id']);
    }

    /**
     * Gets query for [[UserPosts]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserPostsQuery
     */
    public function getUserPosts()
    {
        return $this->hasMany(Posts::class, ['branch_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\BranchesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\BranchesQuery(get_called_class());
    }
}
