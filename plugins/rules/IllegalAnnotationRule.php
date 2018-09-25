<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */

class IllegalAnnotationRule extends RuleBase
{
    /**
     * annotation key word
     * @var array
     */
    private $keyword = array(
        'author',
        'version',
        'return',
        'link',
        'method'
    );

    public function __construct()
    {
        $this->moduleType = ModuleType::FUNC_MODULE;
    }

    public function run(&$context, $modules)
    {
        foreach ($modules as $function) {
            if ($this->filter($function)) {
                continue;
            }
            $text = $function['annotation'];
            $name  = $function['functionName'];
            if (!$this->isKeywordExists($text, $detail)){
                $this->addRuleResult("注释不符合规范.|$detail|Function: $name" . '|Line: ' . $function['start'], $context->getFilePath(), $function['start'], "|$text |Function：$name");
            }
        }
    }

    private function isKeywordExists($text, &$detail){
        if (empty($text)){
            $detail = 'Annotation not found.';
            return false;
        }
        $notExistKeys = array();
        foreach ($this->keyword as $keyword) {
            $isMatched = preg_match('/(\s*\*+\s*@' . $keyword . '\s*([^\*]*)\b)/is', $text, $matches);
            if (!$isMatched) {
                $notExistKeys[] = $keyword;
            }
        }
        if (empty($notExistKeys)){
            return true;
        }
        $detail = implode(',', $notExistKeys) . ' not found.';
        return false;
    }

    /**
     * 过滤
     * @param $func
     * @return bool
     */
    private function filter($func){
        if (strpos($func['functionName'], '_') === 0){
            return true;
        }
        if (strpos($func['mode'], 'private') !== false){
            return true;
        }
        return false;
    }
}