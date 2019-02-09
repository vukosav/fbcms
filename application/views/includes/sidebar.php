<div class="kt-sideleft">
      <label class="kt-sidebar-label">Navigation</label>
      <ul class="nav kt-sideleft-menu">
        <li class="nav-item">
          <a href="<?=base_url()?>" class="nav-link active">
            <i class="icon ion-ios-home-outline"></i>
            <span>Dashboard</span>
          </a>
        </li><!-- nav-item -->
        <li class="nav-item">
          <a href="<?=base_url()?>" class="nav-link with-sub">
            <i class="icon ion-ios-list-outline"></i>
            <span>Posting</span>
          </a>
          <ul class="nav-sub">
            <li class="nav-item"><a href="<?=base_url()?>posting" class="nav-link">Queued posts</a></li>
            <li class="nav-item"><a href="table-datatable.html" class="nav-link">Draft posts</a></li>
            <li class="nav-item"><a href="table-datatable.html" class="nav-link">Sent posts</a></li>
          </ul>
        </li><!-- nav-item -->
        <li class="nav-item">
          <a href="<?=base_url()?>users" class="nav-link active">
            <i class="icon ion-ios-users"></i>
            <span>Users</span>
          </a>
        </li><!-- nav-item -->
      </ul>
    </div>