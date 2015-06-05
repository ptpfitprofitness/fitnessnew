<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin Trainer Manage Certification Index
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
<?php //pr($this->request->data);
//die('here');
 ?>
<?php echo $this->Form->create('Trainer' ,array('controller'=>'trainers', 'action'=>'index', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>

<div class="content"> 

<div class="users index">
 
<?php 
if (($this->Session->check('Message.flash'))) {
	echo $this->Session->flash('flash', array('element' => 'flash'));
}
?>
 
<div class="table">
    <div class="head">
		<h5 class="iFrames">Trainer - <?php echo $trainerinfo['Trainer']['full_name'];?> - Certification</h5>
			<div class="rowElem noborder" style="clear:none;margin-top: -4px;">
			<a href="<?php echo $this->Html->url(array('controller'=>'trainers', 'action'=>'addcerti/'.$trid)); ?>" style="float: right; margin-top:0px; padding: 2px 13px;margin-right:0px;" class='blueBtn'>Add New Certification</a>
		</div>	
	</div>
        <div class="dataTables_wrapper" id="example_wrapper">
			<?php
				
				if(isset($certifications) && count($certifications) > 0){
					$this->Paginator->options(array('url' => array("controller"=>"trainers","action"=>"index/$tab/keyword:$keyword")));
					echo $this->element('admin/paginate');
				} 
			?>
			<br/>
			<table cellspacing="0" cellpadding="0" border="0" id="" class="display">
                <thead>
                    <tr>
						<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;"></div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;">#</div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="20%">
							<div class="DataTables_sort_wrapper">
								Certification Organization
							</div>
						</th>
						
						
						<th class="ui-state-default" rowspan="1" colspan="1">
							<div class="DataTables_sort_wrapper">
								Certification Name
							</div>
						</th>	
						<th class="ui-state-default" rowspan="1" colspan="1">
							<div class="DataTables_sort_wrapper">
								Degree
							</div>
						</th>						
						
						
						
						<th class="ui-state-default" rowspan="1" colspan="1" width="10%">
							<div class="DataTables_sort_wrapper">
								Created
							</div>
						</th>
						
						<th class="ui-state-default" width="10%">
							Action
						</th>
										
					</tr>
                </thead>
				
				<?php
				if(isset($certifications) && count($certifications) > 0){
					$count = 0; 
					foreach($certifications as $prow){
						$index = ((($page-1)*$limit) + ($count+1));
						
					if(trim($prow['CertificationTrainers']['certification_org']))
						$full = trim($prow['CertificationTrainers']['certification_org']);
					else
						$full = trim($prow['CertificationTrainers']['certification_org1']);	
						
					if(trim($prow['CertificationTrainers']['certification_name']))
						$full2 = trim($prow['CertificationTrainers']['certification_name']);
					else
						$full2 = trim($prow['CertificationTrainers']['certification_name1']);	
						
					if(trim($prow['CertificationTrainers']['certification_degree']))
						$full3 = trim($prow['CertificationTrainers']['certification_degree']);
					else
						$full3 = trim($prow['CertificationTrainers']['certification_degree1']);	
						
				?>
				
				<tbody>				
				<tr class="gradeA <?php if($count%2==0) echo 'odd'; else echo 'even';?>">
					<td align="center"></td>
					<td align="center"><?php echo $index;?></td>
					<td><?php echo $full; ?></td>
					<td><?php echo $full2; ?></td>		
					<td><?php echo $full3; ?></td>		
						
					<td align="center"><?php echo date($config['date_format'], strtotime($prow['CertificationTrainers']['added_date'])); ?>
							
							</td>
					<td align="center"><?php echo $this->Html->link($this->Html->image('cross.png'),array('controller'=>'trainers','action'=>'deletecert/'.$prow['CertificationTrainers']['id'] ), array('title'=>'Edit Trainer','escape'=>false));?>
					</td>
					
				</tr>
				<?php $count++; } } ?>
				
				<?php if(isset($certifications) && count($certifications) > 0){?>
					<tr><td colspan="6">
					<div class="rowElem noborder">
						
					</div>
					</td></tr>
				<?php }?>
				</tbody>
			
				</table>
				
				
				<?php
				if(isset($certifications) && count($certifications) > 0){
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