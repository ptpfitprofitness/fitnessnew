<style>    
.vtiger{margin:30px;padding:10px;width:100%;}
.prv{width:48%;border-right:1px solid #ccc;float:left;}
.curr{width:48%;float:left;margin-left:1%;}
.hds{font-size:14px;}
body{font-family:'HelveticaLTCondensedRegular';}
</style>    

<div class="vtiger">      
          <div class="prv">
          <div class="hds"><h3>Previous Measurement</h3></div>
            <?php
          
            if(!empty($response))
            {
            	if($response[1]['SevensiteBodyfat']['status']==1)
			 {
            	?>
            
        <div id="sheetv">
     <table border='1'>
     <tr class="slectedmn">
     <th colspan="10"><h3 style="text-align:center;">Seven Site Body Fat Index</h3><span><?php echo date('l jS F Y',strtotime($response[1]['SevensiteBodyfat']['created_date']));?></span></th>
     </tr>
	     <tr>
		     <th>Weight</th>    
		     <th>Age</th>
		     <th>Chest</th>
		     <th>Abdominal</th>
		     <th>Thigh</th>
		     <th>Triceps</th>
		     <th>Subscapularis</th>
		     <th>Illiac Crest</th>
		     <th>Midaxillary</th>
		     <th>Body Fat</th>
	     
	     </tr>
	     
	     <tr>
	    
		     <td><?php echo $response[1]['SevensiteBodyfat']['weight'];?>(lbs)</td>
		     <td><?php echo $response[1]['SevensiteBodyfat']['age'];?></td>
		     <td><?php echo $response[1]['SevensiteBodyfat']['chest'];?></td>
		     <td><?php echo $response[1]['SevensiteBodyfat']['abs'];?></td>
		     <td><?php echo $response[1]['SevensiteBodyfat']['thigh'];?></td>
		     <td><?php echo $response[1]['SevensiteBodyfat']['triceps'];?></td>
		     <td><?php echo $response[1]['SevensiteBodyfat']['subscapularis'];?></td>
		     <td><?php echo $response[1]['SevensiteBodyfat']['illiaccrest'];?></td>
		     <td><?php echo $response[1]['SevensiteBodyfat']['midaxillary'];?></td>
		     <td><?php echo $response[1]['SevensiteBodyfat']['body_fat'];?>%</td>	     
	     
	     </tr>
     
     </table>
     
     </div>
     
    <div id="mcharts">
    <?php
    
    $bft=$response[1]['SevensiteBodyfat']['body_fat'];
    $leanbweight=100-intval($bft);
    echo $this->GoogleChart->create()
	->setTitle('Seven Site Body Fat', array('size' => 14, 'color' => '000000'))
	->setType('pie', array('3d'))
	->setSize(600, 300)
	->setMargins(10, 10, 10, 10)
	->addData(array($leanbweight, $bft))
	->setPieChartLabels(array('Lean Body Weight', 'Storage Fat'));
	
	
	
    ?>
    </div>
    <?php } }?>
    
    
     <?php
     
            if(!empty($response_threesite))
            {
            	if($response_threesite[1]['ThreesiteBodyfat']['status']==1)
			 {
            	?>
          
            <div id="sheetv">
     <table border='1'>
     <tr class="slectedmn">
     <th colspan="7"><h3 style="text-align:center;">Three Site Body Fat Index</h3><span><?php echo date('l jS F Y',strtotime($response_threesite[1]['ThreesiteBodyfat']['created_date']));?></span></th>
     </tr>
	     <tr>
		        
		     <th>Age</th>
		     <th>Chest</th>
		     <th>Abdominal</th>
		     <th>Thigh</th>
		     <th>Triceps</th>
		     <th>Suprailiac</th>		   
		     <th>Body Fat</th>
	     
	     </tr>
	     <tr>
	    
		     
		     <td><?php echo $response_threesite[1]['ThreesiteBodyfat']['age'];?></td>
		     <td><?php echo $response_threesite[1]['ThreesiteBodyfat']['chest'];?></td>
		     <td><?php echo $response_threesite[1]['ThreesiteBodyfat']['abdominal'];?></td>
		     <td><?php echo $response_threesite[1]['ThreesiteBodyfat']['thigh'];?></td>
		     <td><?php echo $response_threesite[1]['ThreesiteBodyfat']['triceps'];?></td>
		     <td><?php echo $response_threesite[1]['ThreesiteBodyfat']['suprailiac'];?></td>		  
		     <td><?php echo $response_threesite[1]['ThreesiteBodyfat']['body_fat'];?>%</td>	     
	     
	     </tr>
     
     </table>
     
     </div>
     <div id="mcharts">
    <?php
    $bft=$response_threesite[1]['ThreesiteBodyfat']['body_fat'];
    $leanbweight=100-intval($bft);
   echo $this->GoogleChart->create()
	->setTitle('Three Site Body Fat', array('size' => 14, 'color' => '000000'))
	->setType('pie', array('3d'))
	->setSize(600, 300)
	->setMargins(10, 10, 10, 10)
	->addData(array($leanbweight, $bft))
	->setPieChartLabels(array('Lean Body Weight', 'Storage Fat'));
	
	
	
    ?>
    </div>
    <?php } }?>
    
    
      <?php
     
    if(!empty($response_bodyindex))
    {
    	if($response_bodyindex[1]['BodymassIndex']['status']==1)
    	{
    	?>
     <div id="sheetv">
     <table border='1'>
     <tr class="slectedmn">
     <th colspan="4"><h3 style="text-align:center;">Body Mass Index</h3><span><?php echo date('l jS F Y',strtotime($response_bodyindex[1]['BodymassIndex']['created_date']));?></span></th>
     </tr>
	     <tr>
		     <th>Weight</th>    
		     <th>Age</th>
		     <th>Height</th>		    		   
		     <th>BMI</th>
	     
	     </tr>
	     <tr>
	    
		     <td><?php echo $response_bodyindex[1]['BodymassIndex']['weight'];?>(lbs)</td>
		     <td><?php echo $response_bodyindex[1]['ThreesiteBodyfat']['age'];?></td>
		     <td><?php echo $response_bodyindex[1]['BodymassIndex']['height'];?>(Inch)</td>
		     		  
		     <td><?php echo round($response_bodyindex[1]['BodymassIndex']['body_fat'],2);?></td>	     
	     
	     </tr>
     
     </table>
       <div><img src="<?php echo $config['url'];?>images/bmi_chart.png"/></div>
     </div>
      <div class="clear"></div>
      <?php } }?>
    
    </div>
    
    
          <div class="curr">
          <div class="hds"><h3>Current Measurement</h3></div>
          <?php
          
            if(!empty($response))
            {
            	if($response[0]['SevensiteBodyfat']['status']==1)
            	{
            	?>
             
        <div id="sheetv">
     <table border='1'>
     <tr class="slectedmn">
     <th colspan="10"><h3 style="text-align:center;">Seven Site Body Fat Index</h3><span><?php echo date('l jS F Y',strtotime($response[0]['SevensiteBodyfat']['created_date']));?></span></th>
     </tr>
	     <tr>
		     <th>Weight</th>    
		     <th>Age</th>
		     <th>Chest</th>
		     <th>Abdominal</th>
		     <th>Thigh</th>
		     <th>Triceps</th>
		     <th>Subscapularis</th>
		     <th>Illiac Crest</th>
		     <th>Midaxillary</th>
		     <th>Body Fat</th>
	     
	     </tr>
	     
	     <tr>
	    
		     <td><?php echo $response[0]['SevensiteBodyfat']['weight'];?>(lbs)</td>
		     <td><?php echo $response[0]['SevensiteBodyfat']['age'];?></td>
		     <td><?php echo $response[0]['SevensiteBodyfat']['chest'];?></td>
		     <td><?php echo $response[0]['SevensiteBodyfat']['abs'];?></td>
		     <td><?php echo $response[0]['SevensiteBodyfat']['thigh'];?></td>
		     <td><?php echo $response[0]['SevensiteBodyfat']['triceps'];?></td>
		     <td><?php echo $response[0]['SevensiteBodyfat']['subscapularis'];?></td>
		     <td><?php echo $response[0]['SevensiteBodyfat']['illiaccrest'];?></td>
		     <td><?php echo $response[0]['SevensiteBodyfat']['midaxillary'];?></td>
		     <td><?php echo $response[0]['SevensiteBodyfat']['body_fat'];?>%</td>	     
	     
	     </tr>
     
     </table>
     
     </div>
     
    <div id="mcharts">
    <?php
    
    $bft=$response[0]['SevensiteBodyfat']['body_fat'];
    $leanbweight=100-intval($bft);
    echo $this->GoogleChart->create()
	->setTitle('Seven Site Body Fat', array('size' => 14, 'color' => '000000'))
	->setType('pie', array('3d'))
	->setSize(600, 300)
	->setMargins(10, 10, 10, 10)
	->addData(array($leanbweight, $bft))
	->setPieChartLabels(array('Lean Body Weight', 'Storage Fat'));
	
	
	
    ?>
    </div>
    <?php } }?>
    
    
     <?php
     
            if(!empty($response_threesite))
            {
            	if($response_threesite[0]['ThreesiteBodyfat']['status']==1)
            	{
            	?>
          
            <div id="sheetv">
     <table border='1'>
     <tr class="slectedmn">
     <th colspan="7"><h3 style="text-align:center;">Three Site Body Fat Index</h3><span><?php echo date('l jS F Y',strtotime($response_threesite[0]['ThreesiteBodyfat']['created_date']));?></span></th>
     </tr>
	     <tr>
		        
		     <th>Age</th>
		     <th>Chest</th>
		     <th>Abdominal</th>
		     <th>Thigh</th>
		     <th>Triceps</th>
		     <th>Suprailiac</th>		   
		     <th>Body Fat</th>
	     
	     </tr>
	     <tr>
	    
		     
		     <td><?php echo $response_threesite[0]['ThreesiteBodyfat']['age'];?></td>
		     <td><?php echo $response_threesite[0]['ThreesiteBodyfat']['chest'];?></td>
		     <td><?php echo $response_threesite[0]['ThreesiteBodyfat']['abdominal'];?></td>
		     <td><?php echo $response_threesite[0]['ThreesiteBodyfat']['thigh'];?></td>
		     <td><?php echo $response_threesite[0]['ThreesiteBodyfat']['triceps'];?></td>
		     <td><?php echo $response_threesite[0]['ThreesiteBodyfat']['suprailiac'];?></td>		  
		     <td><?php echo $response_threesite[0]['ThreesiteBodyfat']['body_fat'];?>%</td>	     
	     
	     </tr>
     
     </table>
     
     </div>
     <div id="mcharts">
    <?php
    $bft=$response_threesite[0]['ThreesiteBodyfat']['body_fat'];
    $leanbweight=100-intval($bft);
   echo $this->GoogleChart->create()
	->setTitle('Three Site Body Fat', array('size' => 14, 'color' => '000000'))
	->setType('pie', array('3d'))
	->setSize(600, 300)
	->setMargins(10, 10, 10, 10)
	->addData(array($leanbweight, $bft))
	->setPieChartLabels(array('Lean Body Weight', 'Storage Fat'));
	
	
	
    ?>
    </div>
    <?php } }?>
    
    
      <?php
     
    if(!empty($response_bodyindex)){
    	
    	if($response_bodyindex[0]['BodymassIndex']['status']==1)
    	{
    	?>
     <div id="sheetv">
     <table border='1'>
     <tr class="slectedmn">
     <th colspan="4"><h3 style="text-align:center;">Body Mass Index</h3><span><?php echo date('l jS F Y',strtotime($response_bodyindex[0]['BodymassIndex']['created_date']));?></span></th>
     </tr>
	     <tr>
		     <th>Weight</th>    
		     <th>Age</th>
		     <th>Height</th>		    		   
		     <th>BMI</th>
	     
	     </tr>
	     <tr>
	    
		     <td><?php echo $response_bodyindex[0]['BodymassIndex']['weight'];?>(lbs)</td>
		     <td><?php echo $response_bodyindex[0]['ThreesiteBodyfat']['age'];?></td>
		     <td><?php echo $response_bodyindex[0]['BodymassIndex']['height'];?>(Inch)</td>
		     		  
		     <td><?php echo round($response_bodyindex[0]['BodymassIndex']['body_fat'],2);?></td>	     
	     
	     </tr>
     
     </table>
       <div><img src="<?php echo $config['url'];?>images/bmi_chart.png"/></div>
     </div>
      <div class="clear"></div>
      <?php } }?>
    
    </div>
    
     </form>
     </div>
          </div>
           
</div>     
<div style="text-align:center"><img src="<?php echo $config['url'];?>images/body-fat-ref.jpg"></div>
       
      