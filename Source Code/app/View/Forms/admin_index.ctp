<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		04/03/2014
##  Description :		Admin Trainer Packages Index
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
function del(field) {

}


</script> 

<?php echo $this->Form->create('Form' ,array('controller'=>'Forms', 'action'=>'index', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>

<div class="content"> 

<div class="users index">
 
<?php 
if (($this->Session->check('Message.flash'))) {
	echo $this->Session->flash('flash', array('element' => 'flash'));
}
?>
 
<div class="table">
    <div class="head">
		<h5 class="iFrames">Manage Upload</h5>
		<div class="rowElem noborder" style="clear:none;margin-top: -4px;">
			<?php if(isset($forms) && count($forms) > 0){ ?>
				<?php  echo $this->Form->select('Form.status',unserialize($config['status_array']),array('empty'=>'Select','class'=>'topAction','style'=>'width:20%')); ?>&nbsp;
				<?php  echo $this->Form->submit('OK', array('style'=>'float:none;margin-left: -1px;','class'=>'blueBtn submitForm','name'=>'data[Form][submit]', 'div'=>false, 'onclick'=>"return del('data[Form][id][]')",'id'=>'Status'));?>				
				
			<?php 	} ?> 		
				<a href="<?php echo $this->Html->url(array('controller'=>'Forms', 'action'=>'add')); ?>" style="float: right; margin-top:0px; padding: 2px 13px;margin-right:0px;" class='blueBtn'>Add New</a>
		</div>		
	</div>
        <div class="dataTables_wrapper" id="example_wrapper">
			<?php echo $this->Form->create('Form',array('controller'=>'Forms','action'=>'index/'.$this->params["pass"][0],'class'=>'mainForm')); ?>	
				<div class="">
					<div class="dataTables_filter" id="example_filter" style="right:15%;top:-38px;">
						<label>Search: <input type="text" name="keyword" value="<?php echo $keyword;?>" placeholder="Search by Form Title..."/>
						<div class="srch" style="right: 11px;top:4px;"><input style="padding: 2px 3px;" type="submit" name="submit" value="Search"/></div>
						</label>
					</div>
				</div>
			<?php 
				echo $this->Form->end();
				
				if(isset($forms) && count($forms) > 0){
					$this->Paginator->options(array('url' => array("controller"=>"Forms","action"=>"index/$tab/keyword:$keyword")));
					echo $this->element('admin/paginate');
				} 
			?>
			<br/>
			<table cellspacing="0" cellpadding="0" border="0" id="" class="display">
                <thead>
                    <tr>
						<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;"><?php echo $this->Form->text('Form.all', array('type'=>'checkbox', 'id'=>'data[Form][all]', 'onclick'=>"selectDeselect('data[Form][id][]', this.name);"));?></div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;">#</div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="20%">
							<div class="DataTables_sort_wrapper">
								Title
							</div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="20%">
							<div class="DataTables_sort_wrapper">
								Type
							</div>
						</th>
						
						<th class="ui-state-default" rowspan="1" colspan="1" width="10%">
							<div class="DataTables_sort_wrapper">
								Status
							</div>
						</th>
						
						<th class="ui-state-default" width="10%">
							Action
						</th>
										
					</tr>
                </thead>
				
				<?php
				if(isset($forms) && count($forms) > 0){
					$count = 0; 
					foreach($forms as $prow){
						$index = ((($page-1)*$limit) + ($count+1));
					
				?>
				
				<tbody>				
				<tr class="gradeA <?php if($count%2==0) echo 'odd'; else echo 'even';?>">
					<td align="center"><?php echo $this->Form->text('Form.id][', array('type'=>'checkbox', 'value'=>$prow['Form']['id'],  'onclick'=>"checkSelection('data[Form][id][]', 'data[Form][all]')"));?></td>
					<td align="center"><?php echo $index;?></td>
				
					<td><?php echo $prow['Form']['title'] ?></td>		
					<td><?php echo $prow['Form']['type'] ?></td>		
										
					
					<td align="center"><?php 
						if($prow['Form']['status']==1){
							echo $this->Html->image('tick.png');	
						}else{
							echo $this->Html->image('cross.png');
						}	
							?>
							
							</td>
					<td align="center"><?php echo $this->Html->link($this->Html->image('edit-icon.png'),array('controller'=>'Forms','action'=>'edit/'.$prow['Form']['id'] ), array('title'=>'Edit Form','escape'=>false));?>
					<?php echo $this->Html->link($this->Html->image('duplicate.png'),array('controller'=>'Forms','action'=>'duplicate/'.$prow['Form']['id'] ), array('title'=>'Make Duplicate','escape'=>false));?>
					</td>
					
				</tr>
				<?php $count++; } } ?>
				
				<?php if(isset($forms) && count($forms) > 0){?>
					<tr><td colspan="7">
					<div class="rowElem noborder">
						
					</div>
					</td></tr>
				<?php }?>
				</tbody>
			
				</table>
				
				
				<?php
				if(isset($forms) && count($forms) > 0){
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
	$("#Status").click(function(){ $("#valid").submit(); });
</script>		
<?php echo $this->Form->end(); ?>	