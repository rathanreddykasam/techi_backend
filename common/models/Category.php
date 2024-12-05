<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $branch_id
 * @property string $category_name
 * @property int $status
 * @property string $created_on
 *
 * @property Branches $branch
 * @property UserPosts[] $userPosts
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'category_name', 'status'], 'required'],
            [['branch_id', 'status'], 'integer'],
            [['created_on'], 'safe'],
            [['category_name'], 'string', 'max' => 51],
            [['category_name'], 'unique'],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::class, 'targetAttribute' => ['branch_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branch_id' => 'Branch ID',
            'category_name' => 'Category Name',
            'status' => 'Status',
            'created_on' => 'Created On',
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branches::class, ['id' => 'branch_id']);
    }

    /**
     * Gets query for [[UserPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPosts()
    {
        return $this->hasMany(Posts::class, ['category_id' => 'id']);
    }
}
