<?php

namespace app\models\surveys;

/**
 * This is the ActiveQuery class for [[Topics]].
 *
 * @see Topics
 */
class TopicsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Topics[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Topics|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
