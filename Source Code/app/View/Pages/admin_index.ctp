<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		view, page settings and its details
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
<!--
function del(field) {
	 if(!anyChecked(field)) {
	 	// alert('Please select atleast one record to perform any action.');
		jAlert('Please select atleast one record to perform any action.', 'Alert::MyDementiaCare');
	 	return false;
	 } else {
		 if(jQuery('#MemberStatus').val() == 'delete'){
			if(!confirm("Are you sure you want to perform this action?")){
				return false;
			}
		 } else {
			 return true;
		 }
	 }
}
//-->
</script>





<?php echo $this->Form->create('Page' ,array(array('controller'=>'pages', 'action'=>'index'))); ?>

<div class="content"> 

<div class="users index">
 
<?php 
if (($this->Session->check('Message.flash'))) {
	echo $this->Session->flash('flash', array('element' => 'flash'));
}
?>
 
<div class="table">
            <div class="head"><h5 class="iFrames">Manage Page Content</h5></div>
            <div class="dataTables_wrapper" id="example_wrapper">
			<div class="" style="visibility:hidden;">
				<div class="dataTables_filter" id="example_filter">
					<label>Search: <input type="text" placeholder="type here...">
					<div class="srch"></div>
					</label>
				</div>
			</div>
				
			<table cellspacing="0" cellpadding="0" border="0" id="" class="display">
                <thead>
                    <tr>
						
						<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;">#</div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="25%">
							<div class="DataTables_sort_wrapper">
								Title
							</div>
						</th>
						
						<th class="ui-state-default" rowspan="1" colspan="1">
							<div class="DataTables_sort_wrapper">
								Slug
							</div>
						</th>
						
						<th class="ui-state-default" rowspan="1" colspan="1" width="20%">
							<div class="DataTables_sort_wrapper">
								Meta&nbsp;Keywords
							</div>
						</th>
						
					
						<th class="ui-state-default" rowspan="1" colspan="1"  width="13%">
							<div class="DataTables_sort_wrapper">
								Created
							</div>
						</th>
						
						<th class="ui-state-default" rowspan="1" colspan="1"  width="13%">
							<div class="DataTables_sort_wrapper">
								Updated
							</div>
						</th>
						
						<th class="ui-state-default">
							Actions
						</th>
										
					</tr>
                </thead>
				
				<?php
				if(isset($pages) && count($pages) > 0){
					$count = 0; 
					foreach($pages as $prow){
						$index = ((($page-1)*$limit) + ($count+1));
				?>
				
				<tbody>				
				<tr class="gradeA <?php if($count%2==0) echo 'odd'; else echo 'even';?>">
					
					<td align="center"><?php echo $index;?></td>
					<td><?php echo $prow['Page']['page_title'] ?></td>
					<td><?php echo $prow['Page']['page_slug'] ?></td>
					<td><?php echo $prow['Page']['meta_keywords'] ?></td>
					<td><?php echo date($config['date_format'], strtotime($prow['Page']['created'])); ?></td>
					<td><?php echo date($config['date_format'], strtotime($prow['Page']['updated'])); ?></td>
					<td align="center"><?php echo $this->Html->link($this->Html->image('edit-icon.png'),array('controller'=>'pages','action'=>'edit/'.$prow['Page']['id'] ), array('title'=>'Edit page','escape'=>false));?>
					</td>
					
				</tr>
				<?php $count++; } } ?>
				</tbody>
				
				</table>
				
				
				<?php
				if(isset($pages) && count($pages) > 0){
				?>
				
				<?php //echo $this->element('admin/paginate')?>

				<!--<div class="fg-toolbar ui-toolbar  ui-corner-bl ui-corner-br ui-helper-clearfix">
					
					<div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers" id="example_paginate">
							
					</div>
				</div>	-->

				<?php
				}else {
				?>
				<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
					<div class="dataTables_length" id="example_length">
						<label>No Records Available Yet.</label></div>
				</div>
				<?php
				}
				?>
				

				

			</div>
        </div>	
</div>

</div>



<?php echo $this->Form->end(); ?>
