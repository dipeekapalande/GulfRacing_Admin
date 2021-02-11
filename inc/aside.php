<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/businessman.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Admin-Gulf racing</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
	  <?php
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
  
// Here append the common URL characters. 
$link .= "://"; 
  
// Append the host(domain name, ip) to the URL. 
$link .= $_SERVER['HTTP_HOST']; 
  
// Append the requested resource location to the URL 
$link .= $_SERVER['REQUEST_URI']; 
      
// Print the link 

$lastSegment = basename(parse_url($link, PHP_URL_PATH));

		?>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="indexmain.php"><i class="fa fa-circle-o"></i> Home Page </a></li>
           <!-- <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>-->
          </ul>
        </li>
		
		<?php
		if(isset($_SESSION["userrole"]) && $_SESSION["userrole"]=='2')
		{
		?>
			<li <?=(($lastSegment=="camels.php" || $lastSegment=="addcamel.php" || $lastSegment=="editcamel.php")?'class="active"':"")?>>
			  <a href="camels.php">
				<i class="fa fa-calendar-plus-o"></i> <span>Camels Management</span>
				<span class="pull-right-container">
				  <small class="label label-primary pull-right"></small>
				</span>
			  </a>
			</li>
			<li <?=(($lastSegment=="race.php" || $lastSegment=="addrace.php" || $lastSegment=="editrace.php")?'class="active"':"")?>>
			  <a href="race.php" >
				<i class="fa fa-history"></i> <span>Race Management</span>
				<span class="pull-right-container">
				  <small class="label label-primary pull-right"></small>
				</span>
			  </a>
			</li>
			
		<?php
		}
		else{
		?>
		
		<li <?=($lastSegment=="user.php"?'class="active"':"")?>>
          <a href="user.php">
            <i class="fa fa-users"></i> <span>User Managements</span>
            <span class="pull-right-container">
              <small class="label label-primary pull-right">New</small>
            </span>
          </a>
        </li>
		
		
		<li>
          <a href="owner.php">
            <i class="fa fa-user"></i> <span>Sub Admin Management</span>
            <span class="pull-right-container">
              <small class="label label-primary pull-right"></small>
            </span>
          </a>
        </li>
		<li <?=(($lastSegment=="channels.php" || $lastSegment=="addchannel.php" || $lastSegment=="editchannel.php")?'class="active"':"")?>>
          <a href="channels.php">
            <i class="fa fa-film"></i> <span>Channel Management</span>
            <span class="pull-right-container">
              <small class="label label-primary pull-right"></small>
            </span>
          </a>
        </li>
		
		<!--<li>
          <a href="events.php">
            <i class="fa fa-flag-checkered"></i> <span>Event Management</span>
            <span class="pull-right-container">
              <small class="label label-primary pull-right"></small>
            </span>
          </a>
        </li>
		<!--<li>
          <a href="events.php">
            <i class="fa fa-flag-checkered"></i> <span>Event Management</span>
            <span class="pull-right-container">
              <small class="label label-primary pull-right"></small>
            </span>
          </a>
        </li>-->
		
		<li <?=(($lastSegment=="camels.php" || $lastSegment=="addcamel.php" || $lastSegment=="editcamel.php")?'class="active"':"")?>>
          <a href="camels.php">
            <i class="fa fa-calendar-plus-o"></i> <span>Camels Management</span>
            <span class="pull-right-container">
              <small class="label label-primary pull-right"></small>
            </span>
          </a>
        </li>
		<li <?=(($lastSegment=="race.php" || $lastSegment=="addrace.php" || $lastSegment=="editrace.php")?'class="active"':"")?>>
          <a href="race.php" >
            <i class="fa fa-history"></i> <span>Race Management</span>
            <span class="pull-right-container">
              <small class="label label-primary pull-right"></small>
            </span>
          </a>
        </li>
		<li>
          <a href="raceresult.php">
            <i class="fa fa-trophy"></i> <span>Race Result</span>
            <span class="pull-right-container">
              <small class="label label-primary pull-right"></small>
            </span>
          </a>
        </li>
		
		<li>
          <a href="notification.php">
            <i class="fa fa-bell-o"></i> <span>Notification Management</span>
            <span class="pull-right-container">
              <small class="label label-primary pull-right"></small>
            </span>
          </a>
        </li>
		<?php
		}
		?>
		 <!-- <li>
          <a href="subcategory.php">
            <i class="fa fa-files-o"></i> <span>Sub Categories</span>
            <span class="pull-right-container">
              <small class="label label-primary pull-right">New</small>
            </span>
          </a>
        </li>
		  <li>
          <a href="ads.php">
            <i class="fa fa-files-o"></i> <span>Private Ads</span>
            <span class="pull-right-container">
              <small class="label label-primary pull-right">New</small>
            </span>
          </a>
        </li>-->
        <!--<li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Categories</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">8</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Grocery</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Food & Vegitables</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Electronics</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Mobile Accessories</a></li>
			 <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Services</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Fashion</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Home Decors</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Others</a></li>
          </ul>
        </li>-->
        <!--<li>
          <a href="products.php">
            <i class="fa fa-th"></i> <span>Products</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>
		<!--<li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Services</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>-->
		<!--  <li>
          <a href="services.php">
            <i class="fa fa-th"></i> <span>Services</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">All</small>
            </span>
          </a>
        </li>
		  <li>
          <a href="ServiceMembers.php">
            <i class="fa fa-th"></i> <span>Service Members</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">All</small>
            </span>
          </a>
        </li>
		  <li>
          <a href="service_request.php">
            <i class="fa fa-th"></i> <span>Service Request</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">All</small>
            </span>
          </a>
        </li>
		   <li>
          <a href="offers.php">
            <i class="fa fa-th"></i> <span>Offers</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">All</small>
            </span>
          </a>
        </li>
		<li>
          <a href="invoice.php">
            <i class="fa fa-th"></i> <span>Invoices</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>
       <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Charts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
            <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
            <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
            <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>UI Elements</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
            <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
            <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
            <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
            <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Forms</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Tables</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>