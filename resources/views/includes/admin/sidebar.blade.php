<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-header">Admin panel</li>
        <li class="nav-item">
            <a href="{{ route('admin.category') }}" class="nav-link">
                <i class="nav-icon fa fa-list"></i>
                <p>
                    Категории
                    <span class="badge badge-info right">2</span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ asset('/pages/calendar.html') }}" class="nav-link">
                <i class="nav-icon fa fa-shopping-basket"></i>
                <p>
                    Продукты
                    <span class="badge badge-info right">2</span>
                </p>
            </a>
        </li>
    </ul>
</nav>


