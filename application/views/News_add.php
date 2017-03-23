<div id="add_form" class="row">
    <div class="col-md-8 col-lg-offset-2">
        <form action="<?php echo base_url(); ?>news/add" method="post" role="form" enctype="multipart/form-data">
            <div class="form-group">
                <label>Titlu</label>
                <input name="titlu" type="text" class="form-control" placeholder="...">
            </div>
            <div class="form-group">
                <label>Descriere</label>
                <textarea name="continut" class="form-control" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label>Link for Read More</label>
                <input name="link" type="text" class="form-control" placeholder="...">
            </div>
            <div class="form-group">
                <label>Tip Stire</label>
                <select name="tip" class="form-control" value="1">
                    <?php foreach ($types as $type): ?>
                        <option><?php echo $type->tip; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
             <div class="form-group">
                <label>Imagine</label>
                <input type="file" name="userfile">
            </div>
            <button type="submit" class="btn btn-default" name="submit">Send</button>
        </form>
    </div>
</div>
