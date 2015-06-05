<?php 
class CksourceHelper extends FormHelper {

    var $helpers = array('Html');

    function ckeditor($fieldName, $options = array()) {
        //CakePHP 1.2.4.8284
        $value = null;
        $config = null;
        $events = null;
	
        if (array_key_exists('value', $options)) {
            $value = $options['value'];
            if (!array_key_exists('escape', $options) || $options['escape'] !== false) {
                $value = h($value);
            }
            unset($options['value']);
        }
        if (array_key_exists('config', $options)) {
            $config = $options['config'];
            unset($options['config']);
        }
        if (array_key_exists('events', $options)) {
            $events = $options['events'];
            unset($options['events']);
        }

        require_once WWW_ROOT.DS.'js'.DS.'ckeditor'.DS.'ckeditor.php';
        $CKEditor = new CKEditor();
        $CKEditor->basePath = $this->webroot.'js/ckeditor/';

        return $CKEditor->editor($options['name'], $value, $config, $events);
    }
}
?> 