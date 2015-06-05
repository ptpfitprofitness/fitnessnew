<?php
 $line= $clubs[0]['Club'];
 //echo "<pre>";print_r($line);echo "</pre>";
 $this->Csv->addRow(array_keys($line));
 //$header_row = array("Name");
 foreach ($clubs as $club)
 {
      $line = $club['Club'];
	  $this->Csv->addRow($line);
 }
 $filename= 'clubdata';
 echo  $this->Csv->render($filename);
?>