<div class="box row">
    
    
    <div class="search-table col-xs-12 bg-info">
	
	<h2 class="text-center col-xs-12"><?php print SEARCH; ?></h2>
	
	<form id="search-form" class="form-horizontal">
	    <!--<div id="search-fields">-->
		<div class="search-table-inner col-xs-12 col-md-6">
		<?php
		    $halffields = round(count($columns)/2)-2;
		    $counter = 0;
		    foreach ($columns as $name => $attributes)
		    {
			if ($attributes['searchable'] == 1)
			{
			    $counter++;
			    ?>
			    <div class="row_OLD form-group">
				<p class="label_OLD col-xs-12 col-md-3">
				    <?php print $attributes['label']; ?>
				</p>
				<p class="value_OLD col-xs-12 col-md-9">
				    <?php switch ($attributes['format']):
					case 'boolean': ?>
					    <select class="form-control" name="<?php print $name; ?>" id="<?php print $name; ?>-serch">
						<option value="">   </option>
						<option value="yes"
						    <?php if (isset($_POST['search']) && ($_POST[$name] == 'yes')): ?>
							selected
						    <?php endif; ?>
						><?php print YES; ?></option>
						<option value="no"
						    <?php if (isset($_POST['search']) && ($_POST[$name] == 'no')): ?>
							selected
						    <?php endif; ?>
						><?php print NO; ?></option>
					    </select>
					<?php break;
					case 'dropdown':
					    $values = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/addressbook/language/dropdown_$language.ini",true);  ?>
					    <select class="form-control" name="<?php print $name; ?>" id="<?php print $name; ?>-search">
						<option>   </option>
						<?php foreach ($values[$attributes['label']] as $value)
						    { ?>
						    <option value="<?php print $value; ?>"
						    <?php if (isset($_POST['search']) && ($_POST[$name] == $value)): ?>
							selected
						    <?php endif; ?>
						    ><?php print $value; ?></option>    
						<?php
						    } ?>
						</select>
					    <?php break;
					    ?>
				   
					<?php default: ?>
					<input type="text" id="<?php print $name; ?>-search" value="<?php if (isset($_POST['search'])) {print $_POST[$name]; } ?>" name="<?php print $name; ?>" class="form-control" maxlenght="100">
				    
				    <?php endswitch; ?>
				    
				</p>
			    </div> <!--end row-->
			    <?php if ($counter == $halffields):
			    ?>
				</div> <!--end search-table-inner-->
				<div class="search-table-inner col-xs-12 col-md-6">
			    <?php endif; ?>
			<?php } ?> <!--end if searchable-->    
		    <?php } ?> <!--end foraech-->
		</div> <!--end search-table-inner-->
	    <!--</div> end search-fields-->    
	   <!-- <div class="row">-->
		<input type="button" class="btn btn-primary" onclick="searchContacts('<?php print SEARCH_IN_PROGRESS; ?>')" value="<?php print SEARCH; ?>">
		<input type="button" class="btn btn-default" onclick="resetSearchForm()" value="<?php print RESET; ?>" >
	  <!--  </div>-->
	</form>
    </div> <!--end search-table-->
    <p class="message_OLD bg-primary text-center col-xs-12"><?php print SEARCH_INSTRUCTIONS;?></p>
</div>
<div id="searchResults"></div>
<div id="alertBox" class="message_OLD alert alert-warning"></div>
<div id="curtain" class="hide"></div>
<div id="enlargeWindow" class="bg-info">
    <div class="close-button">
    <button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only"><?php print CLOSE; ?></span></button>
    </div>
    <div id="enlargeWindowInner"></div>
    <div class="close-button button_OLD btn btn-default"><?php print CLOSE; ?></div>
</div>
    