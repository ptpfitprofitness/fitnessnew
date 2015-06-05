<?php
 $line= $trainees[0]['Trainee'];
 //echo "<pre>";print_r($line);echo "</pre>";
 $this->Csv->addRow(array_keys($line));
 //$header_row = array("Name");
 foreach ($trainees as $trainee)
 {
      $line = $trainee['Trainee'];
	  $this->Csv->addRow($line);
 }
 $filename= 'traineedata';
 echo  $this->Csv->render($filename);
?>