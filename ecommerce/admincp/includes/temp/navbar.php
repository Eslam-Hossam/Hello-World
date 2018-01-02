
<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="adminpanel.php"><?php echo lang('home_admin')?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?php echo lang('Categories') ?></a></li>
        <li><a href="items.php"><?php echo lang('ITEMS') ?></a></li>
        <li><a href="users.php"><?php echo lang('Users') ?></a></li>
        <li><a href="comments.php"><?php echo lang('COMMENTS') ?></a></li>

      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> eslam <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php"> Home </a> </li>
            <li><a href="users.php?do=Edit&userid=<?php echo $_SESSION['ID']; ?>"><?php echo lang('EditProfile') ?></a></li>
            <li><a href="#"><?php echo lang('Settings') ?></a></li>
            <li><a href="logout.php"><?php echo lang('Logout') ?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
