<div class="kt-sideleft">
      <label class="kt-sidebar-label">Navigation</label>
      <ul class="nav kt-sideleft-menu">
        <li class="nav-item">
          <a href="<?=base_url()?>" class="nav-link <?php if($this->uri->segment(1)==""){echo "active";}?>">
            <i class="icon ion-ios-home-outline"></i>
            <span>Dashboard</span>
          </a>
        </li><!-- nav-item -->
        <!-- <li class="nav-item">
          <a href="<?//=base_url()?>" class="nav-link with-sub <?php //if($this->uri->segment(1)=="posting"){echo "active";}?>">
            <i class="icon ion-ios-list-outline"></i>
            <span>Posting</span>
          </a>
          <ul class="nav-sub">
            <li class="nav-item"><a href="<//?=base_url()?>posting" class="nav-link <?php //if($this->uri->segment(1)=="posting"){echo "active";}?>">Queued posts</a></li>
            <li class="nav-item"><a href="table-datatable.html" class="nav-link">Draft posts</a></li>
            <li class="nav-item"><a href="table-datatable.html" class="nav-link">Sent posts</a></li>
          </ul>
        </li>nav-item -->
        <li class="nav-item">
          <a href="<?=base_url()?>posting/1" class="nav-link <?php if($this->uri->segment(1)=="posting"){echo "active";}?>">
            <i class="icon ion-ios-list-outline"></i>
            <span>Posting</span>
          </a>
        </li><!-- nav-item -->
        <li class="nav-item">
          <a href="<?=base_url()?>groups" class="nav-link <?php if($this->uri->segment(1)=="groups"){echo "active";}?>">
            <i class="fa fa-group"></i>
            <span>Groups</span>
          </a>
        </li><!-- nav-item -->
        <?php if($this->session->userdata('user')['role'] == 1): ?>
        <li class="nav-item">
          <a href="<?=base_url()?>users" class="nav-link <?php if($this->uri->segment(1)=="users"){echo "active";}?>">
            <i class="icon ion-ios-person-outline"></i>
            <span>Users</span>
          </a>
        </li><!-- nav-item -->
        <?php endif; ?>
        <?php if($this->session->userdata('user')['role'] == 1): ?>
        <li class="nav-item">
          <a href="<?=base_url()?>admin" class="nav-link <?php if($this->uri->segment(1)=="admin"){echo "active";}?>">
            <i class="icon ion-ios-cog-outline"></i>
            <span>Admin</span>
          </a>
        </li><!-- nav-item -->
      <?php endif; ?>
        <li class="nav-item">
          <a href="<?=base_url()?>pages" class="nav-link <?php if($this->uri->segment(1)=="pages"){echo "active";}?>">
            <i class="icon ion-document"></i>
            <span>Pages</span>
          </a>
        </li><!-- nav-item -->
      </ul>
    </div><ion-icon name="contacts"></ion-icon>