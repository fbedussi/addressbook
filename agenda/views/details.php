<table class="detail-table">
    <?php
	reset($columns);
	foreach ($row as $name => $value)
	{ ?>
	    <tr>
		<td>
		    <?php if ($name == 'id')
			{
			    print ID;
			} else {
			    $field = each($columns);
			    print $field[1]['label'];
			}
		    ?>
		</td>
		<td>
		    <?php print $name == 'id' ? $value : formatData($value,$columns[$name]['format']); ?>
		</td>
	    </tr>
	<?php } ?>
</table>
<div class="btn-group">
    <a class="button_OLD btn btn-success" onclick="copyOrDeleteContact(<?php print $row['id'] ?>,'<?php print addslashes($row['name'].' '.$row['surname']); ?>','del','<?php print CONFIRM_DELETE; ?>')"><?php print DELETE; ?></a>
    <a class="button_OLD btn btn-success" onclick="edit(<?php print $row['id']; ?>)"><?php print EDIT; ?></a>
    <a class="button_OLD btn btn-success" onclick="copyOrDeleteContact(<?php print $row['id'] ?>,'<?php print addslashes($row['name'].' '.$row['surname']); ?>','copy')"><?php print DUPLICATE; ?></a>
</div>