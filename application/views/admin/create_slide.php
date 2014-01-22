<?php 
    
    $this->load->view('admin/header');

    $class = ($this->router->fetch_method() === 'create_slide' ? 'createSlide' : 'updateSlide');

?>

<form>
    <fieldset>

        <legend>Slide info</legend>

        <section id="image-upload" class="span12">
            
            <div id="slide-image-container" class="image-container span12" style="display: block;">
                <?php if(isset($slide) && $slide->src !== NULL) : ?>
                    <div class="controls-container">
                        <a href="#" data-id="<?php echo $slide->id; ?>" id="delete-slide-image" class="delete-image transition">Delete</a>
                    </div>
                    <img src="<?php echo base_url('/img/home') . '/' . $slide->src; ?>">
                <?php endif; ?>
            </div>

            <div id="qq" class="uploader"></div>

            <hr>

            <div id="upload-container" class="span4">

                <label for="text">Slide text</label>
                <textarea type="text" name="text" id="text" class="span4"><?php if(isset($slide)) echo $slide->text; ?></textarea>

                <br>

                <label for="text_position">Text position</label>
                <select name="text_position" id="text_position" class="span4">
                    <option value="left" <?php if(isset($slide) && $slide->text_position === 'left') echo 'selected'; ?>>Left</option>
                    <option value="right" <?php if(isset($slide) && $slide->text_position === 'right') echo 'selected'; ?>>Right</option>
                </select>

                <br>

                <label for="text_color">Text color</label>
                <select name="text_color" id="text_color" class="span4">
                    <option value="dark" <?php if(isset($slide) && $slide->text_color === 'dark') echo 'selected'; ?>>Black</option>
                    <option value="light" <?php if(isset($slide) && $slide->text_color === 'light') echo 'selected'; ?>>White</option>
                </select>

                <br>

                <label for="order">Sort order</label>
                <input type="text" name="order" id="order" class="span4" value="<?php if(isset($slide)) echo $slide->order; ?>">

            </div>
        </section>

    </fieldset>
    
    <div class="form-actions">
        <button type="submit" id="<?php echo $class; ?>" class="btn btn-primary">Save</button>
        <a href="<?php echo base_url('/admin/homepage'); ?>" class="btn">Cancel</a>
    </div>
</form>

<?php $this->load->view('admin/footer'); ?>