<div class="row pad-top-30">
    <div class="col-md-8">
        <div class="well">
            <div id="blog" class="well">
                <?php if(isset($records)): foreach ($records as $record): ?>
                    <h3> <?php echo $record->titlu; ?> </h3>
                    <small>Posted on <strong> <?php echo $record->data; ?> </strong> by <strong> <?php echo strtoupper($record->prenume) . " " . strtoupper($record->nume); ?> </strong></small>
                    <img src="<?php echo base_url().'uploads/'. $record->image; ?>" alt="<?php echo $record->image; ?>"/>
                    <p><?php echo $record->continut; ?> </p>
                    <a class="readmore" href="<?php echo $record->link; ?>" target="_blank">Read More</a>
                    <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1 || isset($_SESSION['reporter']) && $_SESSION['reporter'] == 1): ?>
                    <a class="readmore" href="<?php echo base_url(); ?>news/add_view" target="_self">Add news</a>
                    <?php endif; if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) { ?>
                        <form action="<?php echo base_url(); ?>news/delete" method="post" class="deleteForm"> <button class="deleteAndEditButtons" type="submit" name="sterge" value="<?php echo $record->id; ?>">Sterge</button> </form>
                        <form action="<?php echo base_url(); ?>news/edit_view/<?php echo $record->id; ?>" method="get" class="editForm"> <button class="deleteAndEditButtons" type="submit">Edit</button> </form>
                    <?php } elseif(isset($_SESSION['reporter']) && $_SESSION['reporter'] == 1 && $_SESSION['username'] == $record->username) { ?>
                        <form action="<?php echo base_url(); ?>news/delete" method="post" class="deleteForm"> <button class="deleteAndEditButtons" type="submit" name="sterge" value="<?php echo $record->id; ?>">Sterge</button> </form>
                        <form action="<?php echo base_url(); ?>news/edit_view/<?php echo $record->id; ?>" method="get" class="editForm"> <button class="deleteAndEditButtons" type="submit">Edit</button> </form>
                     <?php } else { } if(isset($_SESSION['username']) && !empty($_SESSION['username'])) { ?>
                        <div class="likeAndDislike">
                            <a id="l<?php echo $record->id; ?>" class="like" href="<?php echo base_url(); ?>news/like/<?php echo $_SESSION['username'] . '/' . $record->tip . '/' . $record->id; ?>"><span class="glyphicon glyphicon-thumbs-up"></span><span class="ldnum"><?php echo $record->nrLike; ?></span></a>
                            <a id="d<?php echo $record->id; ?>" class="dislike" href="<?php echo base_url(); ?>news/dislike/<?php echo $_SESSION['username'] . '/' . $record->tip . '/' . $record->id; ?>"><span class="glyphicon glyphicon-thumbs-down reverse"></span><span class="ldnum"><?php echo $record->nrDislike; ?></span></a>
                        </div>
                    <?php } ?>
                    <hr>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="list-group">
            <a href="<?php echo base_url(); ?>home" class="list-group-item <?php if(isset($title) && strpos($title, 'News Ro') !== false) echo 'active'; ?>">Home</a>
            <a href="<?php echo base_url(); ?>it" class="list-group-item <?php if(isset($title) && strpos($title, 'IT') !== false) echo 'active'; ?>">IT</a>
            <a href="<?php echo base_url(); ?>economic" class="list-group-item <?php if(isset($title) && strpos($title, 'Economic') !== false) echo 'active'; ?>">Economic</a>
            <a href="<?php echo base_url(); ?>social" class="list-group-item <?php if(isset($title) && strpos($title, 'Social') !== false) echo 'active'; ?>">Social</a>
            <a href="<?php echo base_url(); ?>sport" class="list-group-item <?php if(isset($title) && strpos($title, 'Sport') !== false) echo 'active'; ?>">Sport</a>
        </div>

        <div class="grey-list list-group">
            <div class="topNews">Cele mai apreciate stiri</div>
                <?php if(isset($topNews)) : foreach ($topNews as $news): ?>
                    <a href="<?php echo base_url() . 'search/'. $news[0]->id ; ?>" class="list-group-item">
                        <h4 class="list-group-item-heading"><?php echo $news[0]->titlu; ?></h4>
                    </a>
                <?php endforeach; endif; ?>
        </div>
    </div>
</div>