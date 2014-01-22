<?php 

    $controller = $this->router->fetch_class();
    $backUrl = base_url('/admin') . '/' . $controller;

    $this->load->view('admin/header');

?>

<form>
    <fieldset>

        <legend><?php echo ucfirst($controller); ?>' gallery</legend>

        <section id="image-upload" class="span12">
            <ul id="sortable" class="span12 transition">
                <?php if(isset($images) && !empty($images)) : ?>
                    <?php foreach($images as $i): ?>
                        <li class="ui-state-default">
                            <div class="image-container span4" style="display: block;">
                                <div class="controls-container">
                                    <a href="#" data-id="<?php echo $i->id; ?>" data-section="<?php echo $controller; ?>" class="delete-image transition">Delete</a>
                                </div>
                                <img src="<?php echo base_url('/img') . '/' . $controller . '/' . $i->folder . '/thumbs/' . $i->src; ?>">
                                <div class="headline-container">
                                    <textarea name="edit-headline" id="edit-headline" rows="1" placeholder="Image headline"><?php echo $i->title; ?></textarea>
                                    <textarea name="edit-link" id="edit-link" rows="1" placeholder="Buy me link"><?php echo $i->link; ?></textarea>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <div id="upload-container" class="span4">

                <input type="text" name="headline" id="headline" class="span4" placeholder="Image headline">

                <input type="text" name="link" id="link" class="span4" placeholder="Buy me link">

                <div id="qq" class="uploader pull-right"></div>
                
            </div>
        </section>

    </fieldset>
    
    <div class="form-actions">
        <button type="submit" id="createGallery" class="btn btn-primary">Save</button>
        <a href="<?php echo base_url('/admin') . '/' . $this->router->fetch_class(); ?>" class="btn">Cancel</a>
    </div>
</form>

<?php $this->load->view('admin/footer'); ?>