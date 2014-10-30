<?php $numberOfResults = count($results) ?>

    <p class="message_OLD alert alert-success"><?php print N_OF_RESULTS.' '.$numberOfResults; ?></p>
    
    <?php if ($numberOfResults >0): ?>
    
    <a class="button_OLD btn btn-default" href="#table-end"><?php print GO_DOWN; ?></a>
    
     <div class="btn-group">
        <a class="button_OLD btn btn-success" onclick="javascript:checkAll('search-results-table', true);"><?php print SELECT_ALL; ?></a>
        <a class="button_OLD btn btn-success" onclick="javascript:checkAll('search-results-table', false);"><?php print DESELECT_ALL; ?></a>
        <a class="button_OLD btn btn-success" onclick="javascript:deleteAll('<?php print DELETE_SELECTED_CONFIRMATION; ?>')"><?php print DELETE_SELECTED; ?></a>
        <a class="button_OLD btn btn-success" onclick="javascript:filterSelected()"><?php print FILTER_SELECTED; ?></a>
    </div>
    
    <div class="btn-group">
        <a href="agenda/labels.php" target="_blank" class="button btn btn-primary"><?php print PRINT_LABELS; ?></a>
        <a href="agenda/envelope.php?size=small" target="_blank" class="button btn btn-primary"><?php print PRINT_ENVELOPE11x25; ?></a>
        <a href="agenda/envelope.php?size=medium" target="_blank" class="button btn btn-primary"><?php print PRINT_ENVELOPE16x23; ?></a>
        <a href="agenda/envelope.php?size=big" target="_blank" class="button btn btn-primary"><?php print PRINT_ENVELOPE19x23; ?></a>
    </div>
					
    
    <a class="button_OLD btn btn-default" href="#" id="back-to-top"><?php print GO_UP; ?></a>
    
   
    
    <table class="contact-table_OLD compact display" id="search-results-table" width="100%">
        <thead>
            <tr class="table-header">
                <td>
                    <?php print ID; ?>
                </td>
                <?php foreach ($columns as $column)
                        {
                            if ($column['visible'] == 1): ?>
                                <td>
                                    <?php print $column['label']; ?>
                                </td>
                            <?php endif; 
                        } ?>
            </tr>
        </thead>
        <tbody id="tbody">
            <?php foreach ($results as $row)
                { ?>
                <tr>
                    <!--print the ID column with links-->
                    <td>
                        <p class="id">                    
                            <Input type="checkbox" name="cb[]" value="<?php print $row['id']; ?>" >
                            <?php print $row['id']; ?>
                        </p>
                            <button type="button" class="btn btn-default btn-xs" onclick="details(<?php print $row['id']; ?>)">
                              <span class="glyphicon glyphicon-zoom-in"></span>
                            </button>
                            
                            <button type="button" class="btn btn-default btn-xs" onclick="copyOrDeleteContact(<?php print $row['id'] ?>,'<?php print addslashes($row['name'].' '.$row['surname']); ?>','del','<?php print CONFIRM_DELETE; ?>')">
                              <span class="glyphicon glyphicon-remove"></span>
                            </button>
                            
                            <button type="button" class="btn btn-default btn-xs" onclick="edit(<?php print $row['id']; ?>)">
                              <span class="glyphicon glyphicon-edit"></span>
                            </button>
                            
                            <button type="button" class="btn btn-default btn-xs" onclick="copyOrDeleteContact(<?php print $row['id'] ?>,'<?php print addslashes($row['name'].' '.$row['surname']); ?>','copy')">
                              <span class="glyphicon glyphicon-plus"></span>
                            </button>
                            
                    </td>
                    <!--print the other columns-->
                    <?php foreach ($row as $cellName => $cellData)
                        {
                            if (array_key_exists($cellName,$columns) && ($columns[$cellName]['visible'] == 1)): ?>
                                <td>
                                    <?php print formatData($cellData,$columns[$cellName]['format']); ?>
                                </td>
                            <?php endif; ?>
                        <?php } ?>
                    
                </tr>
                    
                <?php } ?>
        </tbody>
        
    </table>
    <div id="table-end"></div>
    
    <div class="btn-group">
        <a class="button_OLD btn btn-success" onclick="javascript:checkAll('search-results-table', true);"><?php print SELECT_ALL; ?></a>
        <a class="button_OLD btn btn-success" onclick="javascript:checkAll('search-results-table', false);"><?php print DESELECT_ALL; ?></a>
        <a class="button_OLD btn btn-success" onclick="javascript:deleteAll('<?php print DELETE_SELECTED_CONFIRMATION; ?>')"><?php print DELETE_SELECTED; ?></a>
        <a class="button_OLD btn btn-success" onclick="javascript:filterSelected()"><?php print FILTER_SELECTED; ?></a>
    </div>
    

<?php endif; ?>