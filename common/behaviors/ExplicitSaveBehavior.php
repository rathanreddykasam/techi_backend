<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class ExplicitSaveBehavior extends Behavior
{
    private $canSave = false;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'checkCanSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'checkCanSave',
        ];
    }

    public function checkCanSave($event)
    {
        if (!$this->canSave) {
            $event->isValid = false;
        }
    }

    public function beforeSave($event)
    {
        $this->canSave = false;
    }

    public function allowSave()
    {
        $this->canSave = true;
    }

    public function afterSave($event)
    {
        $this->canSave = false;
    }
}
