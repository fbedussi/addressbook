<html>
<head>
	<title><?php print HEADER.' - '.PRINT_ENVELOPES; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php print "/addressbook/template/$template/css"; ?>/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php print "/addressbook/template/$template/css"; ?>/envelope.css" />
	<!--<link rel="stylesheet" type="text/css" href="print.css" />-->
</head>

<body>

<FORM class="center">
    <INPUT TYPE="button" onClick="window.print()" value="<?php print PRINT_LABEL; ?>">
    <input type=button value="<?php print CLOSE; ?>" onClick="javascript:window.close()" name="button">
</FORM>
  <?php foreach ($results as $id => $row)
    { ?>
    <div class="envelope break <?php print $size; ?>">
	<img src="<?php print "/addressbook/".$logo; ?>" />
	<p>
	<?php
	$line = "";
	foreach ($addressFormat as $addressElement)
	      {
		if  (array_key_exists($addressElement, $row))
		{
		  $line .= htmlentities($row[$addressElement]);
		  $prevEmpty = ($row[$addressElement] == '') ? true : false;
		} else {
		  
		  $line = (substr($line,-1) == '(') ? substr($line,0,strlen($line)-1) : $line;
		  
		  switch ($addressElement)
		  {
		    case " ":
		     $line .= ($prevEmpty) ? "" : " ";
		     break;
		    case "line":
		      print ($line != "") ? $line."<br />" : "";
		      $line = '';
		      break;
		    case ")":
		      $line .= ($prevEmpty == true) ? "" : ")";
		      break;
		    case "(":
		      $line .= "(";
		      
		  }
		  
		  
		}
	      }
	?>
	
	</p>
    </div>
   <?php } ?>
  <p class="center"><a class="button" href="#"><?php print GO_UP; ?></a></p>

</body>
</html>