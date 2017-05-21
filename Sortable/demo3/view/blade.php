<?php foreach ($rows as $key => $row) { ?>

<div data-id="<?php echo $row['id']?>" class="list-group-item">
    <span class="badge"><?php echo $row['id']?></span>
    <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['data']?>
</div>

<?php }?>