<div class="alert alert-danger">
    <div class="row text-center">
        <?php
            print DEL_CONFIRM.' '.'<strong>'.$user->getName().'</strong>';
        
        ?>
    </div>
    <div class="row text-center">
        <a class="btn btn-primary" href="<?php print $_SERVER['PHP_SELF'] ?>"><?php print NO ?></a>
        <a class="btn btn-default" href="<?php print $_SERVER['PHP_SELF']."?confirmdel=1&id=".$_GET["id"] ?>"><?php print YES ?></a>
    </div>
</div>