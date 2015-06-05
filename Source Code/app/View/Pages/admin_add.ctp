<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		view, page settings and its details
## *****************************************************************
?>
<div class="content">
    <div class="title"><h5>Manage Members</h5></div>
<div class="content" id="container">

<?php echo $this->Form->create('Page' ,array('controller'=>'pages', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->
<fieldset>
	<div class="widget first">
		<div class="head"><h5 class="iList">Add New Page</h5></div>
		
			<div class="rowElem noborder"><label>Page Title:</label><div class="formRight">
				<?php echo $this->Form->text('Page.page_title', array('maxlength'=>255,'id'=>'PageTitle', 'class'=>'validate[required]')); ?>
				<?php echo $this->Form->error('Page.page_title', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
		
			<div class="rowElem noborder"><label>Page Slug:</label><div class="formRight">
				<?php echo $this->Form->text('Page.page_slug', array('maxlength'=>128,'id'=>'PageSlug', 'class'=>'validate[required,ajax[uniqueSlug]]')); ?>
				<?php echo $this->Form->error('Page.page_slug', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder">
				<label>Page Content :</label>
				<div class="formRight">                        
					<?php echo $this->Form->textarea('Page.page_content', array('id'=>'PageContent', 'class'=>'validate[required]')); ?>
					<?php echo $this->Form->error('Page.page_content', null, array('class' => 'error')); ?>
				</div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Meta Keyword:</label>
				<div class="formRight">                        
					<?php echo $this->Form->text('Page.meta_keywords'); ?>
					<?php echo $this->Form->error('Page.meta_keywords', null, array('class' => 'error')); ?>
				</div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder"><label>Meta Description</label><div class="formRight">
				<?php echo $this->Form->textarea('Page.meta_description'); ?>
				<?php echo $this->Form->error('Page.meta_description', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
			
			<input type="reset" value="Reset" class="greyishBtn submitForm" />
			<input type="submit" value="Save" class="greyishBtn submitForm" />
			<input type="button" value="Cancel" class="greyishBtn submitForm" onclick="location.href='<?php echo $this->Html->url('/admin/members/index/');?>'" />
			
			<div class="fix"></div>

	</div>
</fieldset>
<?php echo $this->Form->end(); ?>

    </div>
    
<div class="fix"></div>
</div>

</div>
