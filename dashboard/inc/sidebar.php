<div class="sidebar-shrink p-3 bg-white" id="sidebar">
    <button class="btn text-red bg-white shadow-sm" id="sidebar-toggler">
        <i class="fa fa-chevron-right" aria-hidden="true"></i>
    </button>

    <ul class="text-capitalize text-dark py-3">
        <li class="p-2">
            <a href="./" class="nav-link">
                <i class="fa fa-cogs" aria-hidden="true"></i>
                <b class="sidebar-nav-text d-none"> dashboard</b>
            </a>
        </li>
        <li class="dropright p-2 sidebar-drop">
            <a class="nav-link sidebar-dropper" data-toggle="dropdown" id='menu'>
                <i class="fa fa-list" aria-hidden="true"></i>
                <b class="sidebar-nav-text d-none"> menu</b>
            </a>

            <div class="dropdown-menu border-none shadow-sm sidebar-drops" id="menu-drop">
                <a href="./menu.php" class="nav-link dropdown-item p-2"> all menu</a>
                <a href="./menu.php?add" class="nav-link dropdown-item p-2"> add new</a>
            </div>
        </li>
        </li>
        <li class="p-2">
            <a href="./order.php" class="nav-link">
                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                <b class="sidebar-nav-text d-none"> orders</b>
            </a>

        </li>
        <!-- <li class="p-2">
            <a href="./employees.php" class="nav-link">
                <i class="fa fa-users" aria-hidden="true"></i>
                <b class="sidebar-nav-text d-none"> Employees</b>
            </a>

        </li>
        <li class="p-2">
            <a href="./customers.php" class="nav-link">
                <i class="fa fa-object-group" aria-hidden="true"></i>
                <b class="sidebar-nav-text d-none"> Users</b>
            </a>

        </li> -->
    </ul>
</div>