<?php $this->load->view('admin/header'); ?>

<h4 class="admin-header">Manage slides</h4>

<hr />

<div class="admin-top-container">
    <a href="<?php echo base_url('/admin/homepage/create_slide'); ?>" class="btn">Create new slide</a>
    <input id="filter" class="pull-right search-query" type="text" placeholder="Search" />
</div>
<table class="footable" data-filter="#filter" data-page-navigation="#pagination" data-page-size="15">
    <thead>
        <tr>
            <th data-hide="phone" data-type="numeric" data-sort-initial="true">Order</th> 
            <th data-class="expand">Text</th>
            <th data-hide="phone">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($slides)): ?>
            <?php foreach($slides as $s): ?>
                <tr>
                    <td><?php echo $s->order; ?></td>
                    <td><?php echo $s->text; ?></td>
                    <td>
                        <a href="<?php echo base_url('/admin/homepage/edit_slide') . '/' . $s->id; ?>">Edit</a> / 
                        <a href="#" class="delete-slide" data-id="<?php echo $s->id; ?>" data-order="<?php echo $s->order; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="empty-notif">There is no data for this section yet. Why not <a href="<?php echo base_url('/admin/homepage/create'); ?>">create</a> some?</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<ul id="pagination" class="footable-nav pull-right"></ul>

<?php $this->load->view('admin/footer'); ?>