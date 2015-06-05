<?php

##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Admin club Index
## *****************************************************************
echo $this->Html->css('dataTable'); ?> 

<?php echo $this->Html->script('dataTables/jquery.dataTables'); ?> 
<?php echo $this->Html->script('dataTables/colResizable.min'); ?> 

<?php echo $this->Html->script('jBreadCrumb.1.1'); ?> 
<?php echo $this->Html->script('cal.min'); ?> 
<?php echo $this->Html->script('jquery.collapsible.min'); ?> 
<?php echo $this->Html->script('jquery.ToTop'); ?> 
<?php echo $this->Html->script('jquery.listnav'); ?> 
<?php echo $this->Html->script('jquery.sourcerer'); ?> 

<?php echo $this->Html->script('wysiwyg/jquery.wysiwyg'); ?> 
<?php echo $this->Html->script('wysiwyg/wysiwyg.image'); ?> 
<?php echo $this->Html->script('wysiwyg/wysiwyg.link'); ?> 
<?php echo $this->Html->script('wysiwyg/wysiwyg.table'); ?> 

<?php echo $this->Html->script('flot/jquery.flot'); ?> 
<?php echo $this->Html->script('flot/jquery.flot.pie'); ?> 
<?php echo $this->Html->script('flot/excanvas.min'); ?> 

<?php echo $this->Html->script('selectunselect'); ?> 

<?php
	if(isset($status) && trim($status)!=""){
		$url = array($status);
		$this->Paginator->options(array('url' => $url));
	}
?>

<script type="text/javascript">

</script> 
<?php echo $this->Form->create(null,array('controller'=>'index', 'action'=>'contactrequest',  'class'=>'mainForm', 'id'=>'valid')); ?>

<div class="content"> 

<div class="users index">
 
<?php 
if (($this->Session->check('Message.flash'))) {
	echo $this->Session->flash('flash', array('element' => 'flash'));
}
?>
 
<div class="table">
    <div class="head">
		<h5 class="iFrames">Manage Contact Query</h5>
		<div class="rowElem noborder" style="clear:none;margin-top: -4px;">
			<?php if(isset($contactslist) && count($contactslist) > 0){ ?>
				<?php  echo $this->Form->select('Contact.statusTop',unserialize($config['status_array']),array('empty'=>'Select','class'=>'topAction','style'=>'width:20%')); ?>&nbsp;
				<?php  echo $this->Form->submit('OK', array('style'=>'float:none;margin-left: -1px;','class'=>'blueBtn submitForm','name'=>'data[Contact][submit]', 'div'=>false, 'onclick'=>"return del('data[Contact][id][]')",'id'=>'StatusTop'));?>				
				
			<?php 	} ?> 		
				
		</div>		
	</div>
        <div class="dataTables_wrapper" id="example_wrapper">
			<?php echo $this->Form->create('ContactRequest',array('controller'=>'index','action'=>'contactrequest/'.$this->params["pass"][0],'class'=>'mainForm')); ?>	
				<div class="">
					<div class="dataTables_filter" id="example_filter" style="right:15%;top:-38px;">
						<label>Search: <input type="text" name="keyword" value="<?php echo $keyword;?>" placeholder="Search by First Name OR Last Name..."/>
						<div class="srch" style="right: 11px;top:4px;"><input style="padding: 2px 3px;" type="submit" name="submit" value="Search"/></div>
						</label>
					</div>
				</div>
			<?php 
				echo $this->Form->end();
				
				if(isset($contactslist) && count($contactslist) > 0){
					$this->Paginator->options(array('url' => array("controller"=>"index","action"=>"contactrequest/$tab/keyword:$keyword")));
					echo $this->element('admin/paginate');
				} 
			?>
			<br/>
			<table cellspacing="0" cellpadding="0" border="0" id="" class="display">
                <thead>
                    <tr>
						<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;"><?php echo $this->Form->text('Contact.all', array('type'=>'checkbox', 'id'=>'data[Contact][all]', 'onclick'=>"selectDeselect('data[Contact][id][]', this.name);"));?></div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;">#</div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width=10%">
							<div class="DataTables_sort_wrapper">
								First Name
							</div>
						</th>
						
						
						<th class="ui-state-default" rowspan="1" colspan="1">
							<div class="DataTables_sort_wrapper">
								Last Name
							</div>
						</th>						
						
						<th class="ui-state-default" rowspan="1" colspan="1"  width="13%">
							<div class="DataTables_sort_wrapper">
								Email
							</div>
						</th>
							<th class="ui-state-default" rowspan="1" colspan="1"  width="13%">
							<div class="DataTables_sort_wrapper">
								Phone
							</div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1"  width="23%">
							<div class="DataTables_sort_wrapper">
								Request
							</div>
						</th>
						
						<th class="ui-state-default" rowspan="1" colspan="1"  width="8%">
							<div class="DataTables_sort_wrapper">
								Added Date
							</div>
						</th>
						
						
						
						<th class="ui-state-default" rowspan="1" colspan="1" width="10%">
							<div class="DataTables_sort_wrapper">
								Status
							</div>
						</th>
						
						<!--<th class="ui-state-default" width="10%">
							Action
						</th>-->
										
					</tr>
                </thead>
				
				<?php
				if(isset($contactslist) && count($contactslist) > 0){
					$count = 0; 
					foreach($contactslist as $prow){
						$index = ((($page-1)*$limit) + ($count+1));
						
					
				?>
				
				<tbody>				
				<tr class="gradeA <?php if($count%2==0) echo 'odd'; else echo 'even';?>">
					<td align="center"><?php echo $this->Form->text('Contact.id][', array('type'=>'checkbox', 'value'=>$prow['Contact']['id'],  'onclick'=>"checkSelection('data[Contact][id][]', 'data[Contact][all]')"));?></td>
					<td align="center"><?php echo $index;?></td>
					<td><?php echo $prow['Contact']['first_name']; ?><br/>
					
					</td>
					<td><?php echo $prow['Contact']['last_name'] ?></td>		
					<td><?php echo $prow['Contact']['email'] ?></td>		
					<td><?php echo $prow['Contact']['phone'] ?></td>		
					<td><?php echo $prow['Contact']['comment'] ?></td>		
										
					<td align="center"><?php echo date($config['date_format'], strtotime($prow['Contact']['added_date'])); ?></td>
					<td align="center"><?php 
						if($prow['Contact']['status']==1){
							echo $this->Html->image('tick.png');	
						}else{
							echo $this->Html->image('cross.png');
						}	
							?>
							
							</td>
					<!--<td align="center"><?php //echo $this->Html->link($this->Html->image('edit-icon.png'),array('controller'=>'librarys','action'=>'editlibrary/'.$prow['ExerciseLibrary']['id'] ), array('title'=>'Edit Library','escape'=>false));?>
					</td>-->
					
				</tr>
				<?php $count++; } } ?>
				
				<?php if(isset($contactslist) && count($contactslist) > 0){?>
					<tr><td colspan="6">
					<div class="rowElem noborder">
						<?php  //echo $this->Form->select('FoodNutritionLog.status',unserialize($config['status_array']),array('empty'=>'Select', 'id'=>'Status','style'=>'width:20%;float:left;')); ?>&nbsp;
						<?php  //echo $this->Form->submit('OK', array('style'=>'float:left;','class'=>'blueBtn submitForm','name'=>'data[FoodNutritionLog][submit]', 'div'=>false, 'onclick'=>"return del('data[FoodNutritionLog][id][]')"));?>
					</div>
					</td></tr>
				<?php }?>
				</tbody>
			
				</table>
				
				
				<?php
				if(isset($contactslist) && count($contactslist) > 0){
				?>
				
				<?php echo $this->element('admin/paginate')?>

				<?php
				}else {
				?>
				<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
					<div class="dataTables_length" id="example_length" style="width:100%;text-align:center;">
						No records available yet.
					</div> 
				</div>
				<?php
				}
				?> 
			</div>
        </div>	
	</div>
</div>
<style>.topAction{border: 1px solid #D5D5D5;font-size: 12px;padding: 4px;width: 20%;}</style>
<script>
	$("#StatusTop").click(function(){ $("#valid").submit(); });
</script>		
<?php echo $this->Form->end(); ?>	