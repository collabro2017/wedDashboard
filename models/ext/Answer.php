<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13/04/15
 * Time: 09:37
 */

namespace app\models\ext;

/**
 * Class Answer
 * @package app\models\ext
 */
/**
 * Class Answer
 * @package app\models\ext
 */
class Answer extends \app\models\Answer {
    /**
     * @return bool
     */
    public function beforeDelete()
    {
        $result = true;
        foreach ($this->triviaAnswers as $answer) {
            $result = $result && $answer->delete();
        }

        return $result && parent::beforeDelete();
    }
}