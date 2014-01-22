<div id="main-bar" class="topbar">
  <div class="topbar-inner">
    <div class="container-fluid">
      <a class="brand" href="<?php echo base_url('admin/'); ?>" title="Admin Home">Dreamhouse Admin</a>
      <ul class="nav">
        
        <li><a href="<?php echo base_url('admin/menu');?>">Menu</a></li>
        
        <li><a href="<?php echo base_url('admin/galleries');?>">Galleries</a></li>
        
        <li><a href="<?php echo base_url('admin/comments');?>">Comments</a></li>
        
        
        
        <?php if($this->session->userdata('privilegies') == 1):?>
        <li><a href="<?php echo base_url('admin/users/');?>">Users</a></li>
        <?php endif;?>
      </ul>
      <ul class="nav secondary-nav">
        <li><a href="<?php echo base_url();?>">Site</a></li>
        <li class="dropdown">
            <a class="dropdown-toggle">User</a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo base_url('admin/users/editUser/'.$this->session->userdata('user_id')); ?>">Edit profile</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url('admin/login/logout');?>">Logout</a></li>
            </ul>
        </li>
      </ul>
    </div>
  </div>
</div><!-- End .topbar --> 