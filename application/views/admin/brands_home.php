<?php $this->load->view('admin/header'); ?>

<h4 class="admin-header">Manage brands</h4>

<hr />

<div class="admin-top-container">
    <a href="<?php echo base_url('/admin/brands/create'); ?>" class="btn">Create new brand</a>
    <input id="filter" class="pull-right search-query" type="text" placeholder="Search" />
</div>
<table class="footable" data-filter="#filter" data-page-navigation="#pagination" data-page-size="15">
    <thead>
        <tr>
            <th data-hide="phone" data-type="numeric" data-sort-initial="true">Order</th> 
            <th data-class="expand">Name</th> 
            <th data-hide="phone">Description</th>
            <!-- <th data-hide="phone">Description EN</th> -->
            <th data-hide="phone">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($brands)): ?>
            <?php foreach($brands as $b): ?>
                <tr>
                    <td><?php echo $b->order; ?></td>
                    <td><?php echo $b->brand; ?></td>
                    <td><?php echo (strlen($b->description_cz) > 150 ? substr($b->description_cz, 0, 150) . '...' : $b->description_cz); ?></td>
                    <td>
                        <a href="<?php echo base_url('/admin/brands/edit') . '/' . $b->id; ?>">Edit</a> / 
                        <a href="#" class="delete-someone" data-id="<?php echo $b->id; ?>" data-section="<?php echo $this->router->fetch_class(); ?>" data-folder="<?php echo $b->folder; ?>" data-name="<?php echo $b->brand; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="empty-notif">There is no data for this section yet. Why not <a href="<?php echo base_url('/admin/brands/create'); ?>">create</a> some?</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<ul id="pagination" class="footable-nav pull-right"></ul>

<?php $this->load->view('admin/footer'); ?>