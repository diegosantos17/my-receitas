<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Trainning <sup>POO MVC</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    {% for menu in session.SidebarMenu %}

    <!-- Heading -->
    <div class="sidebar-heading">
        {{menu.cabecalho}}
    </div>

    {% for subMenu1Item in menu.subMenu1 %}
    
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#{{subMenu1Item.id}}" aria-expanded="true" aria-controls="{{subMenu1Item.id}}">
            <i class="{{subMenu1Item.icon}}"></i>
            <span>{{subMenu1Item.cabecalho}}</span>
        </a>
        <div id="{{subMenu1Item.id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">{{subMenu1Item.subTitulo}}:</h6>
        
                {% for subMenu2Item in subMenu1Item.subMenu2 %}

                <a class="collapse-item" href="{{subMenu2Item.url}}">{{subMenu2Item.nome}}</a>

                {% endfor %}
            </div>
        </div>
    </li>

    {% endfor %}

    <!-- Divider -->
    <hr class="sidebar-divider">

    {% endfor %}

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>