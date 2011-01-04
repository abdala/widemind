<?php
class Zend_View_Helper_Rename
{
    const CLASSNAME = 'rename_editable';
    
    public function rename($value)
    {
        return '<span class="'.self::CLASSNAME.'">'
               .Zend_Registry::get('rename')->_($value)
               .'</span>';
    }
}