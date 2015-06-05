<?php
 $line= $trainers[0]['Trainer'];
 //echo "<pre>";print_r($line);echo "</pre>";
 $this->Csv->addRow(array_keys($line));
 //$header_row = array("Name");
 foreach ($trainers as $trainer)
 {
      $line = $trainer['Trainer'];
	  $this->Csv->addRow($line);
 }
 $filename= 'trainerdata';
 echo  $this->Csv->render($filename);
?>