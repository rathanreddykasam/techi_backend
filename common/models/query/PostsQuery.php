<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\UserPosts]].
 *
 * @see \common\models\UserPosts
 */
class PostsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Posts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Posts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
