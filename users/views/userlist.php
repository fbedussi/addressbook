<table id="user-list">
    <thead>
        <tr>
            <td><?php print ID ?></td>
            <td><?php print NAME ?></td>
            <!--<td><?php print PASSWORD ?></td>-->
            <td><?php print ACTIONS ?></td>
        </tr>
    </thead>
    
    <tbody>
        
        <?php foreach ($allUser as $row): ?>
        
            <tr>
                
                <td>
                    <?php print $row['id'] ?>
                </td>
                <td>
                    <?php print $row['name'] ?>
                </td>
                <!--<td>
                    <?php print $row['pwd'] ?>
                </td>-->
                <td>
                    <a href="user.php?id=<?php print $row['id'] ?>&del=1"><?php print DELETE ?></a><br />
                    <a href="user.php?id=<?php print $row['id'] ?>&edit=1"><?php print EDIT ?></a>
                </td>
            </tr>
        
        <?php endforeach ?>
        
        
    </tbody>
    
    

</table>

<form action="<?php print $_SERVER['PHP_SELF'] ?>" method="post" class="form-inline">
    <h3><?php print ADD_USER; ?></h3>
    <div class="form-group">
        <label class="sr-only">
            <?php print NAME ?>
        </label>
        <input type="text" name="name" placeholder="<?php print NAME ?>" class="form-control">
    </div>
    <div class="form-group">
        <label class="sr-only">
            <?php print PASSWORD ?>
        </label>
        <input type="password" name="pwd" placeholder="<?php print PASSWORD ?>" class="form-control">
    </div>
    <div class="form-group">
        <label class="sr-only">
            <?php print CONFIRM_PASSWORD ?>
        </label>
        <input type="password" name="confirmPwd" placeholder="<?php print CONFIRM_PASSWORD ?>" class="form-control">
    </div>
    <input type="submit" value="<?php print ADD ?>" name="add" class="btn btn-primary">    
</form>

<script type="text/javascript" charset="utf8" src="/addressbook/js/users.js"></script>
