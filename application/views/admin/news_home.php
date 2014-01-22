<?php $this->load->view('admin/header'); ?>

<h4 class="admin-header">Manage news</h4>

<hr />

<div class="admin-top-container">
    <a href="<?php echo base_url('admin/news/create'); ?>" class="btn">Create new article</a>
    <input id="filter" class="pull-right search-query" type="text" placeholder="Search" />
</div>
<table class="footable" data-filter="#filter" data-page-navigation="#pagination" data-page-size="15">
    <thead>
        <tr>
            <th data-hide="phone" data-type="numeric" data-sort-initial="true">Date</th> 
            <th data-class="expand">Headline</th> 
            <th data-hide="phone">Text</th>
            <th data-hide="phone">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($news)): ?>
            <?php foreach($news as $n): ?>
                <tr>
                    <td><?php echo $n->date; ?></td>
                    <td><?php echo (strlen($n->headline_cz) > 75 ? substr($n->headline_cz, 0, 75) . '...' : $n->headline_cz); ?></td>
                    <td><?php echo (strlen($n->text_cz) > 150 ? substr($n->text_cz, 0, 150) . '...' : $n->text_cz); ?></td>
                    <td>
                        <a href="<?php echo base_url('/admin/news/edit') . '/' . $n->id; ?>">Edit</a> / 
                        <a href="#" class="delete-news" data-id="<?php echo $n->id; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="empty-notif">There is no data for this section yet. Why not <a href="#">create</a> some?</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<ul id="pagination" class="footable-nav pull-right"></ul>

<?php $this->load->view('admin/footer'); ?>