<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all 
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	public function equal($check, $check_field) {
    	$value = array_values($check);
    	if($this->data[$this->name][$check_field] == $value[0]){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    public function alphaNumericDashUnderscore($check) {
        $value = array_values($check);
        $value = $value[0];
        return preg_match('|^[0-9a-zA-Z_-]*$|', $value);
	}
	public  function unbindModelAll() {
		foreach(array(
		'hasOne' => array_keys($this->hasOne),
		'hasMany' => array_keys($this->hasMany),
		'belongsTo' => array_keys($this->belongsTo),
		'hasAndBelongsToMany' => array_keys($this->hasAndBelongsToMany)
		) as $relation => $model) {
		$this->unbindModel(array($relation => $model));
		}
	}
	public function customLoadModel($modelname,$newObject = false){
		if($newObject){
		ClassRegistry::removeObject($modelname);
		}
		return ClassRegistry::init($modelname);
	}
	public function validate_passwords() {
		
    return $this->data[$this->alias]['password'] === $this->data[$this->alias]['con_password'];
}
}
