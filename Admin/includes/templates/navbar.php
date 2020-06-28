<nav class="navbar navbar-inverse">
  <div class="container">
   
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-toggle" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><?php echo lang('brand') ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="nav-toggle">
      <ul class="nav navbar-nav">
        <li><a href="categories.php?sort=ASC"><?php echo lang('sections') ?><span class="sr-only">(current)</span></a></li>
       <li><a href="items.php"><?php echo lang('items') ?><span class="sr-only">(current)</span></a></li>
        <li><a href="members.php"><?php echo lang('members') ?><span class="sr-only">(current)</span></a></li>
        <li><a href="comments.php"><?php echo lang('comments') ?><span class="sr-only">(current)</span></a></li>
              </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['username'] ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['id']; ?>"><?php echo lang('edit-profile') ?></a></li>
            <li><a href="#"><?php echo lang('settings') ?></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>