<?php

namespace shopium\mod\admin\models\query;

use yii\db\ActiveQuery;

class LanguagesQuery extends ActiveQuery {

    public function published($state = 1) {
        return $this->andWhere(['switch' => $state]);
    }

}
