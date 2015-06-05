<?php
/**
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
 * @package       Cake.View.Layouts.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
	<title><?php echo $title_for_layout;?></title>
</head>
<body>
	<?php /*<div style="margin:5px 0;padding:5px 0;border-bottom:1px solid #AAAAAA;"><img src="<?php echo Configure::read('Website.url').'app/webroot/img/logo.png' ?>" width="150px" /></div>*/ ?>
	<div style="padding:10px;margin-bottom:10px;border-bottom:1px solid #AAAAAA;"><?php echo $content_for_layout;?></div>
	<div style="padding:5px;font-size:10px;"><p>This email has sent from <a href="<?php echo Configure::read('Website.url');  ?>" style="color:#565656;text-decoration:none;"><?php echo Configure::read('Website.base_title'); ?></a></p></div>
</body>
</html>