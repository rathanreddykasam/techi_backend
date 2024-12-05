<?php

namespace common\models;

use common\behaviors\ExplicitSaveBehavior;

use Yii;

/**
 * This is the model class for table "user_posts".
 *
 * @property int $id
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
 * @property PostComments[] $postComments
 * @property PostEditor[] $postEditors
 * @property TeamImages[] $teamImages
 * @property User $user
 */
class Posts extends \yii\db\ActiveRecord
{
    public $bannerFile; // Temporary attribute for banner file upload
    public $logoFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_posts';
    }


    public function fields()
    {
        // If this is an individual view (e.g., /posts/123), return all attributes
        if (Yii::$app->controller->action->id === 'view') {
            $fields = parent::fields();

            $fields['bannerUrl'] = 'bannerUrl';
            $fields['logoUrl'] = 'logoUrl';

            return $fields; // Return all fields
        }

        // For index (e.g., /posts), return only specific fields
        return ['id', 'user_id', 'Intro', 'logo', 'banner', 'bannerUrl', 'logoUrl', 'heading', 'tagline'];
    }

    public function behaviors()
    {
        return [
            'explicitSave' => [
                'class' => ExplicitSaveBehavior::class,
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'branch_id', 'category_id', 'heading', 'tagline', 'Intro', 'story', 'team_size', 'status', 'post_as'], 'required'],
            [['user_id', 'branch_id', 'category_id', 'video_key', 'team_size', 'status', 'created_by', 'post_as'], 'integer'],
            [['Intro', 'story', 'some_text'], 'string'],
            [['created_on', 'posted_on'], 'safe'],
            [['heading'], 'string', 'max' => 50],
            [['banner', 'logo'], 'string', 'max' => 101],
            [['banner', 'logo'], 'string', 'max' => 101], // Ensure these are strings in DB
            [['bannerFile', 'logoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, png'],
            [['tagline', 'site_link'], 'string', 'max' => 100],
            [['video'], 'string', 'max' => 150],
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
     * Get the full URL for the banner image.
     * 
     * @return string|null
     */
    public function getBannerUrl()
    {
        if ($this->banner) {
            return Yii::$app->request->hostInfo . Yii::getAlias('@web') . '/images/' . $this->banner;
        }
        return null; // Return null if no banner exists
    }

    /**
     * Get the full URL for the logo image.
     * 
     * @return string|null
     */
    public function getLogoUrl()
    {
        if ($this->logo) {
            return Yii::$app->request->hostInfo . Yii::getAlias('@web') . '/images/' . $this->logo;
        }
        return null; // Return null if no logo exists
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
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[PostComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostComments()
    {
        return $this->hasMany(PostComments::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[PostEditors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostEditors()
    {
        return $this->hasMany(PostEditor::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[TeamImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeamImages()
    {
        return $this->hasMany(TeamImages::class, ['post_id' => 'id']);
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

    public static function find()
    {
        return new \common\models\query\PostsQuery(get_called_class());
    }

    /**
     * Override save to enable the save operation explicitly.
     *
     * @param bool $runValidation
     * @param array|null $attributeNames
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->getBehavior('explicitSave')->allowSave(); // Allow saving explicitly
        $result = parent::save($runValidation, $attributeNames);
        $this->getBehavior('explicitSave')->afterSave(null); // Reset after save
        return $result;
    }
}
