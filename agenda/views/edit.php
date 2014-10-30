<form id="add-form" class="detail-table form-horizontal" >
    <?php
	$fieldsToGet = '"id", '; ?>
	<div class="row_OLD form-group">
	    <p class="label_OLD control-label col-xs-3" id="id-label">ID</p>
	    <p class="value_OLD col-xs-9">
		<input class="form-control" id="id-value" value="<?php print $record['id']; ?>" disabled>
	    </p>
	</div>
	<?php
	foreach ($columns as $name => $attributes)
	{
	    if ($attributes['searchable'] == 1)
	    {
		$fieldsToGet .= '"'.$name.'", ';
		?>
		<div class="row_OLD form-group">
		    <p class="label_OLD control-label col-xs-3" id="<?php print $name; ?>-label">
			<?php print $attributes['label']; ?>
		    </p>
		    <p class="value_OLD col-xs-9">
			<?php switch ($attributes['format']):
			    case 'boolean': ?>
				<select name="<?php print $name; ?>" id="<?php print $name; ?>-value" class="form-control">
				    <option value="">   </option>
				    <option value="yes"
					<?php if ($record[$name] == 'yes'): ?>
					    selected
					<?php endif; ?>
				    ><?php print YES; ?></option>
				    <option value="no"
					<?php if ($record[$name]  != 'yes'): ?>
					    selected
					<?php endif; ?>
				    ><?php print NO; ?></option>
				</select>
			    <?php break;
			    case 'dropdown':
				$values = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/addressbook/language/dropdown_$language.ini",true);  ?>
				<select name="<?php print $name; ?>" id="<?php print $name; ?>-value" class="form-control">
				    <?php if (!in_array($record[$name],$values)): ?>
					<option selected><?php print $record[$name]; ?></option>
				    <?php endif; ?>
				    <?php foreach ($values[$attributes['label']] as $value)
					{ ?>
					<option value="<?php print $value; ?>"
					<?php if ($value == $record[$name]): ?>
					    selected
					<?php endif; ?>
					><?php print $value; ?></option>    
				    <?php
					} ?>
				    
					
				    </select>
				<?php break;
			    case 'text':?>
				<textarea class="form-control" value="<?php print $record[$name]; ?>" name="<?php print $name; ?>" cols="54" rows="10" id="<?php print $name; ?>-value"></textarea>
				<?php break;
			    default: ?>
			    <input class="form-control" id="<?php print $name; ?>-value" type="text" value="<?php print $record[$name]; ?>" name="<?php print $name; ?>" size="50" maxlenght="100">
			
			<?php endswitch; ?>
			
		    </p>
		</div> <!--end row-->
	    <?php } ?> <!--end if searchable-->    
	<?php } ?> <!--end foraech-->
	<div class="row_OLD">
	    <input type="button" class="btn btn-primary" name="add"  id="add-contact-button" onclick='editContact(<?php print substr($fieldsToGet,0,strlen($fieldsToGet)-2); ?>)' value="<?php print SAVE_EDITING; ?>">
	   <!-- <a class="button" id="add-contact-button" onsubmit="addContact()"><?php print SAVE_EDITING; ?></a>-->
	</div>
    </div> <!--end search-table-inner-->
</form>