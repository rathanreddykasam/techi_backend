<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_posts}}".
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property int $branch_id
 * @property int $category_id
 * @property string $heading
 * @property string $banner
 * @property string $logo
 * @property string $tagline
 * @property string $Intro
 * @property string $story
 * @property string $site_link
 * @property string $video
 * @property int $video_key
 * @property int $team_size
 * @property string $some_text
 * @property int $status
 * @property int $created_by
 * @property string $created_on
 * @property string $posted_on
 * @property int $post_as
 *
 * @property Branches $branch
 * @property Category $category
 * @property PostEditor[] $postEditors
 * @property TeamImages[] $teamImages
 * @property User $user
 */
class UserPosts extends \yii\rest\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_posts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id', 'branch_id', 'category_id', 'heading', 'banner', 'logo', 'tagline', 'Intro', 'story', 'site_link', 'video', 'video_key', 'team_size', 'some_text', 'status', 'created_by', 'post_as'], 'required'],
            [['post_id', 'user_id', 'branch_id', 'category_id', 'video_key', 'team_size', 'status', 'created_by', 'post_as'], 'integer'],
            [['Intro', 'story', 'some_text'], 'string'],
            [['created_on', 'posted_on'], 'safe'],
            [['heading'], 'string', 'max' => 50],
            [['banner', 'logo'], 'string', 'max' => 101],
            [['tagline', 'site_link'], 'string', 'max' => 100],
            [['video'], 'string', 'max' => 150],
            [['post_id'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'branch_id' => 'Branch ID',
            'category_id' => 'Category ID',
            'heading' => 'Heading',
            'banner' => 'Banner',
            'logo' => 'Logo',
            'tagline' => 'Tagline',
            'Intro' => 'Intro',
            'story' => 'Story',
            'site_link' => 'Site Link',
            'video' => 'Video',
            'video_key' => 'Video Key',
            'team_size' => 'Team Size',
            'some_text' => 'Some Text',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'posted_on' => 'Posted On',
            'post_as' => 'Post As',
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\BranchesQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branches::class, ['id' => 'branch_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[PostEditors]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PostEditorQuery
     */
    public function getPostEditors()
    {
        return $this->hasMany(PostEditor::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[TeamImages]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TeamImagesQuery
     */
    public function getTeamImages()
    {
        return $this->hasMany(TeamImages::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\UserPostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserPostsQuery(get_called_class());
    }
}
