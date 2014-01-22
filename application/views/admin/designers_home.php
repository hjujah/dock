<?php $this->load->view('admin/header'); ?>

<h4 class="admin-header">Manage designers</h4>

<hr />

<div class="admin-top-container">
    <a href="<?php echo base_url('admin/designers/create'); ?>" class="btn">Create new designer</a>
    <input id="filter" class="pull-right search-query" type="text" placeholder="Search" />
</div>
<table class="footable" data-filter="#filter" data-page-navigation="#pagination" data-page-size="15">
    <thead>
        <tr>
            <th data-hide="phone" data-type="numeric" data-sort-initial="true">Order</th> 
            <th data-class="expand">Name</th> 
            <th data-hide="phone">Category</th>
            <th data-hide="phone">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($designers)): ?>
            <?php foreach($designers as $d): ?>
                <tr>
                    <td><?php echo $d->order; ?></td>
                    <td><?php echo $d->name; ?></td>
                    <td><?php echo $d->category; ?></td>
                    <td>
                        <a href="<?php echo base_url('/admin/designers/edit') . '/' . $d->id; ?>">Edit</a> / 
                        <a href="#" class="delete-someone" data-id="<?php echo $d->id; ?>" data-section="<?php echo $this->router->fetch_class(); ?>" data-folder="<?php echo $d->folder; ?>" data-name="<?php echo $d->name; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="empty-notif">There is no data for this section yet. Why not <a href="<?php echo base_url('admin/designers/create'); ?>">create</a> some?</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<ul id="pagination" class="footable-nav pull-right"></ul>

<?php $this->load->view('admin/footer'); ?>