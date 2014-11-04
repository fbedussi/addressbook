<form action="<?php print $_SERVER['PHP_SELF']."?id=".$user->getUserId() ?>" method="post">
    <div class="form-group">
        <label>
            <?php print NAME ?>
        </label>
        <input type="text" name="name" value="<?php print $user->getName() ?>" class="form-control">
    </div>
    <div class="form-group">
        <label>
            <?php print PASSWORD ?>
        </label>
        <input type="password" name="pwd" value="<?php print $user->getPassword() ?>" class="form-control">
    </div>
    <input type="submit" value="<?php print CONFIRM ?>" name="edited" class="btn btn-primary">    
</form>