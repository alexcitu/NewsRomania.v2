<div id="add_form" class="row">
    <div class="col-md-8 col-lg-offset-2">
        <form action="<?php echo base_url(); ?>news/update" method="post" role="form" enctype="multipart/form-data">
            <div class="form-group">
                <label>Titlu</label>
                <input name="titlu" type="text" class="form-control" value="<?php echo $newsDetails[0]->titlu; ?>">
            </div>
            <div class="form-group">
                <label>Descriere</label>
                <textarea name="continut" class="form-control" rows="10"><?php echo $newsDetails[0]->continut; ?></textarea>
            </div>
            <div class="form-group">
                <label>Link for Read More</label>
                <input name="link" type="text" class="form-control" value="<?php echo $newsDetails[0]->link; ?>">
            </div>
            <div class="form-group">
                <label>Tip Stire</label>
                <select name="tip" class="form-control">
                    <?php foreach ($types as $type):
                        if($type->tip == $newsDetails[0]->tip) { ?>
                            <option selected><?php echo $type->tip; ?></option>
                        <?php } else {?>
                            <option><?php echo $type->tip; ?></option>
                        <?php } ?>
                    <?php endforeach; ?>
                </select>
            </div>
             <div class="form-group">
                <label>Imagine</label>
                <input type="file" name="userfile">
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" class="btn btn-default" name="submit">Send</button>
        </form>
    </div>
</div>
