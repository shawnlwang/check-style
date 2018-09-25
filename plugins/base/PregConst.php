<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */

class PregConst
{
    const PREG_FUNCTION = '/\b\s*([(public)|(private)|(protected)|(static)]*)\s*function\b\s*(\w*)\b[\s|\(]/is';

    const PREG_CALL_FUNCTION = '/[->|::]\s?(\w*)\s?\(/is';

    const PREG_CLASS_NAME = '/\b\s*[(public)|(private)|(protected)|(static)]*\s*class\b\s*(\w*)\b[\s|{]/is';

    const PREG_NEW_INSTANCE = '/\bnew\s?(\w*)\s?\(/is';

    const PREG_ANNOTATION_ROW = '/(^\s*[\/\*]+)|(^\s*$)/is';
}