<?php 
    
    $method = $this->router->fetch_method();
    $backUrl = base_url('/admin/news');
    $buttonClass = 'createNews';

    if(isset($news)) {
        $editGalleryUrl = base_url('/admin/news/edit_gallery') . '/' . $news[0]->id;
        $buttonClass = 'updateNews';
    }

    $this->load->view('admin/header');

?>

<form>
    <fieldset>

        <legend>General info</legend>

        <label for="headline_cz">Headline CZ</label>
        <input type="text" name="headline_cz" id="headline_cz" class="span4" value="<?php if(isset($news)) echo $news[0]->headline_cz; ?>">

        <label for="headline">Headline EN</label>
        <input type="text" name="headline" id="headline" class="span4" value="<?php if(isset($news)) echo $news[0]->headline; ?>">

        <label for="text_cz">Text CZ</label>
        <textarea name="text_cz" id="text_cz" class="span4"><?php if(isset($news)) echo $news[0]->text_cz; ?></textarea>

        <label for="text">Text EN</label>
        <textarea name="text" id="text" class="span4"><?php if(isset($news)) echo $news[0]->text; ?></textarea>

        <label for="size">Size</label>
        <input type="text" name="size" id="size" class="span4" value="<?php if(isset($news)) echo $news[0]->size; ?>">

    </fieldset>

    <div class="form-actions">
        <button id="<?php echo $buttonClass; ?>" class="btn btn-primary">Save</button>
        <?php if($method === 'edit') : ?>
            <a href="<?php echo $editGalleryUrl; ?>" class="btn btn-primary">Edit Gallery</a>
        <?php endif; ?>
        <a href="<?php echo $backUrl; ?>" class="btn">Cancel</a>
    </div>
</form>

<?php $this->load->view('admin/footer'); ?>