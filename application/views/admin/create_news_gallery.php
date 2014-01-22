<?php 

    $controller = $this->router->fetch_class();
    $backUrl = base_url('/admin') . '/' . $controller;

    $this->load->view('admin/header');

?>

<form>
    <fieldset>

        <legend>News gallery</legend>

        <section id="image-upload" class="span12">
            <ul id="sortable" class="span12 transition">
                <?php if(isset($images) && !empty($images)) : ?>
                    <?php foreach($images as $i): ?>
                        <li class="ui-state-default">
                            <div class="image-container span4" style="display: block;">
                                <div class="controls-container">
                                    <a href="#" data-id="<?php echo $i->id; ?>" class="delete-image transition">Delete</a>
                                </div>
                                <img src="<?php echo base_url('/img') . '/news/' . $i->src; ?>">
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <div id="upload-container" class="span4">

                <div id="qq" class="uploader pull-right"></div>
                
            </div>
        </section>

    </fieldset>
    
    <div class="form-actions">
        <button type="submit" id="createGallery" class="btn btn-primary">Save</button>
        <a href="<?php echo base_url('/admin/news'); ?>" class="btn">Cancel</a>
    </div>
</form>

<?php $this->load->view('admin/footer'); ?>