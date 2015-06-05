<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		view, page settings and its details
## *****************************************************************
echo $this->Html->script('ckeditor/ckeditor');?>
<div class="content">
    

<div class="content" id="container">

<?php echo $this->Form->create('Page' ,array('controller'=>'pages', 'action'=>'edit', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<?php echo $this->Form->hidden('Page.id'); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Edit Page Content</h5></div>

		

			<div class="rowElem noborder"><label>Page Title<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Page.page_title', array('maxlength'=>255,'id'=>'PageTitle', 'class'=>'validate[required]')); ?>

				<?php echo $this->Form->error('Page.page_title', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

		

			<div class="rowElem noborder"><label>Page Slug<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Page.page_slug', array('maxlength'=>128,'id'=>'PageSlug', 'lang'=>$this->data['Page']['id'],  'class'=>'validate[required,ajax[uniqueSlugEdit]]')); ?>

				<?php echo $this->Form->error('Page.page_slug', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

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
			
			
			<div class="rowElem noborder">

				<label>Page Content US<span style="color:red;">*</span> :</label>

				<div class="formRight">                      
					<?php 
						echo $this->Cksource->create('CKSource');
						echo $this->Cksource->ckeditor('page_content',array('name'=>'data[Page][page_content]','value'=>$this->data['Page']['page_content']));
						
						
					?>
					 
					  
					<?php echo $this->Form->error('Page.PageContent', null, array('class' => 'error')); ?>

				</div>

				<div class="fix"></div>

			</div>
			
			<div class="rowElem noborder">

				<label>Page Content UK<span style="color:red;">*</span> :</label>

				<div class="formRight">                      
					<?php 
						echo $this->Cksource->create('CKSource');
						echo $this->Cksource->ckeditor('page_content_uk',array('name'=>'data[Page][page_content_uk]','value'=>$this->data['Page']['page_content_uk']));
						
						
					?>
					 
					  
					<?php echo $this->Form->error('Page.PageContent_uk', null, array('class' => 'error')); ?>

				</div>

				<div class="fix"></div>

			</div>
		

			
			<input type="submit" value="Save" class="blueBtn submitForm" />

			<input type="button" value="Cancel" class="blueBtn submitForm" onclick="location.href='<?php echo $this->Html->url('/admin/pages/');?>'" />

			

			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>

