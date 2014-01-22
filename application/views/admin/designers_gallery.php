<?php $this->load->view('admin/header'); ?>

<form>
    <fieldset>

        <legend><?php echo ucfirst($this->router->fetch_class()); ?>' gallery</legend>

        <section id="image-upload" class="span12">
            <div id="upload-container" class="span4">
                <div class="image-container"></div>

                <label for="headline">Image headline</label>
                <input type="text" name="headline" id="headline" class="span4">

                <div id="qq" class="uploader pull-right"></div>

                <label class="checkbox">
                    <input type="checkbox"> Set as default thumbnail
                </label>
            </div>
        </section>

    </fieldset>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?php echo base_url('/admin') . '/' . $this->router->fetch_class(); ?>" class="btn">Cancel</a>
    </div>
</form>

<?php $this->load->view('admin/footer'); ?>