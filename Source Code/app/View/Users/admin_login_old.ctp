<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		view, page settings and its details
## *****************************************************************
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Login | Admin | <?php echo $config['base_title']; ?></title>



<?php echo $this->Html->css('main'); ?>

<link href="http://fonts.googleapis.com/css?family=Cuprum" rel="stylesheet" type="text/css" />

<script type="text/javascript">

var site_url = '<?php echo $config['url']; ?>';

var site_img_url = '<?php echo $config['url']; ?>app/webroot/img/';

</script>

<!-- Inculude JS -->

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>

<?php echo $this->Html->script('jquery-1.4.4'); ?> 



<?php echo $this->Html->script('spinner/jquery.mousewheel'); ?> 

<?php echo $this->Html->script('spinner/ui.spinner'); ?> 



<?php echo $this->Html->script('forms/forms'); ?> 

<?php echo $this->Html->script('forms/autogrowtextarea'); ?> 

<?php echo $this->Html->script('forms/autotab'); ?> 

<?php echo $this->Html->script('forms/jquery.validationEngine-en'); ?> 

<?php echo $this->Html->script('forms/jquery.validationEngine'); ?> 



<?php echo $this->Html->script('ui/progress'); ?>

<?php echo $this->Html->script('ui/jquery.jgrowl'); ?>

<?php echo $this->Html->script('ui/jquery.tipsy'); ?>

<?php echo $this->Html->script('ui/jquery.alerts'); ?>



<?php echo $this->Html->script('admin_custom.js'); ?> 



</head>



<body>



<!-- Top navigation bar -->

<div id="topNav">

    <div class="fixed">

        <div class="wrapper" style="width:1032px;">

            <div class="backTo"><?php echo $this->Html->image('platform/logo.png');?></div>

            <div class="userNav">

				<a href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'forgotpassword')); ?>" title="Forgot Password"><span>Forgot Password</span></a>


            </div>

            <div class="fix"></div>

        </div>

    </div>

</div>





<!-- Login form area -->

<div class="loginWrapper2" style="top:25%; left:36%; position:absolute;">



	<div class="loginLogo2" style="padding-bottom:15px; text-align:center;">

		    &nbsp;

	</div>

	

	<?php if(isset($errorMessage)){ ?>

	<div style="width:320px;">

		<div class="nNote nFailure hideit">

			<p><strong>Error: </strong>

				<?php echo $errorMessage; ?>

			</p>

		</div>

	</div>

	<?php } ?>



	<?php 

	if (($this->Session->check('Message.flash'))) {

		echo $this->Session->flash('flash', array('element' => 'flash'));

	}

	?>

		

    <div class="loginPanel">

        <div class="head"><h5 class="iUser">Login</h5></div>

		<?php echo $this->Form->create('Admin', array('id'=>'valid', 'url' => array('controller' => 'users', 'action' => 'login'), 'class'=>'mainForm'));?>

            <fieldset>

				

                <div class="loginRow noborder">

                    <label for="req1">Username <span style="color:red;">*</span>:</label>

                    <div class="loginInput">

						<?php echo $this->Form->input('Admin.login',array("id"=>"Login", "label"=>false, "class"=>"validate[required]", 'style' => 'width:170px;'));?>

					</div>

                    <div class="fix"></div>

                </div>

                

                <div class="loginRow">

                    <label for="req2">Password <span style="color:red;">*</span>:</label>

                    <div class="loginInput">

						<?php echo $this->Form->input('Admin.password', array("id"=>"Password","type"=>"password","label"=>false, "class"=>"validate[required]", 'style' => 'width:170px;'));?>

					</div>

                    <div class="fix"></div>

                </div>

				

				

                <div class="loginRow" style="padding-bottom:0px;">

                    <input type="submit" value="Log me in" class="greyishBtn submitForm" style="margin-bottom:15px;" />

                    <div class="fix"></div>

                </div>

            </fieldset>

		<?php

			echo $this->Form->end();

		?>

    </div>
</div>

	<!-- Footer -->
	<div id="footer" style="position:absolute;">
		<div class="wrapper">
			<span>&copy; Copyright <?php echo date("Y");?>. All rights reserved. Powered by <a href="#" title="">Synapse India</a></span>
		</div>
	</div>
</body>
</html>

