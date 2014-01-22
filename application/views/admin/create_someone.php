<?php 
    
    $controller = $this->router->fetch_class();
    $method = $this->router->fetch_method();
    $backUrl = base_url('/admin') . '/' . $controller;
    $buttonClass = 'createSomeone';

    if(isset($someone)) {
        $editGalleryUrl = base_url('/admin') . '/' . $controller . '/edit_gallery/' . $someone->id . '/' . $someone->folder;
        $buttonClass = 'updateSomeone';

        if($controller === 'brands') {
            $someone->name = $someone->brand;
        }
    }

    $this->load->view('admin/header');

?>

<form>
    <fieldset>

        <legend>General info</legend>

        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="span4" value="<?php if(isset($someone)) echo $someone->name; ?>">
        
        <?php if($controller !== 'brands') : ?>
            <label for="category">Category</label>
            <input type="text" name="category" id="category" class="span4" value="<?php if(isset($someone)) echo $someone->category; ?>">
        <?php else: ?>
            <label for="link">Link</label>
            <input type="text" name="link" id="link" class="span4" value="<?php if(isset($someone)) echo $someone->link; ?>">
        <?php endif; ?>

        <label for="description_cz">Description CZ</label>
        <textarea name="description_cz" id="description_cz" class="span4"><?php if(isset($someone)) echo $someone->description_cz; ?></textarea>
        <br>

        <label for="description">Description EN</label>
        <textarea name="description" id="description" class="span4"><?php if(isset($someone)) echo $someone->description; ?></textarea>
        <br>
        
        <?php if(!isset($someone)) : ?>
            <label for="folder">
                Folder<br>
                (This field represents the pretty URL name of the <?php echo substr($controller, 0, -1); ?><br> and it's folder name on the server and is mandatory!)
            </label>
            <input type="text" name="folder" id="folder" class="span4">
        <?php endif; ?>

        <label for="order">Sort order</label>
        <input type="text" name="order" id="order" class="span4" value="<?php if(isset($someone)) echo $someone->order; ?>">

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