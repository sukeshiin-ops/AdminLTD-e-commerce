@php
    use App\Models\Attribute;
    $att = Attribute::with('AttributeValue')->get();
    $att_value = Attribute::where('type', 1)->get();
@endphp

<aside class="app-sidebar shadow-lg" style="background: linear-gradient(180deg,#2f3247,#1e2133);" data-bs-theme="dark">

    <!-- Brand -->
    <div class="sidebar-brand text-center py-3 border-bottom border-secondary">
        <a href="{{ asset('admin/index.html') }}" class="brand-link text-decoration-none">
            <img style="border-radius: 50%; width:45px;"
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5TPu3HoTZkTyxzVY6h3fuKo-nPU85G5u4Vw&s"
                class="shadow mb-2" />
            <div class="text-white fw-semibold">Admin Panel</div>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar-wrapper px-2">
        <nav class="mt-3">

            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.page') }}" class="nav-link active rounded">
                        <i class="nav-icon bi bi-grid"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- User Management -->
                <li class="nav-item mt-2">
                    <a href="#" class="nav-link rounded">
                        <i class="nav-icon bi bi-people"></i>
                        <p>User Management <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>

                    <ul class="nav nav-treeview ps-3">
                        <li class="nav-item">
                            <a href="{{ route('view-All-User.now') }}" class="nav-link">
                                <i class="bi bi-list"></i>
                                <p>All Users</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('add.user.now') }}" class="nav-link">
                                <i class="bi bi-person-plus"></i>
                                <p>Add User</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Product Management -->
                <li class="nav-item mt-2">
                    <a href="#" class="nav-link rounded">
                        <i class="nav-icon bi bi-box"></i>
                        <p>Product Management <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>

                    <ul class="nav nav-treeview ps-3">
                        <li class="nav-item">
                            <a href="{{ route('view.all.product') }}" class="nav-link">
                                <i class="bi bi-list"></i>
                                <p>All Product</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('add.user.now') }}" class="nav-link">
                                <i class="bi bi-plus-circle"></i>
                                <p>Add Product</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('show.all.attribute') }}" class="nav-link">
                                <i class="bi bi-ui-checks"></i>
                                <p>All Attribute</p>
                            </a>
                        </li>

                        <!-- Attribute Values -->
                        <li class="nav-item">
                                @foreach ($att_value as $value)

                                        <a class="nav-link" href="{{ route('edit-value.show', $value->id) }}">
                                           <i class="far fa-dot-circle"></i>
                                            <p>{{ $value->name }}</p>
                                        </a>
                                @endforeach

                        </li>
                    </ul>
                </li>

                <!-- Category Management -->
                <li class="nav-item mt-2">
                    <a href="#" class="nav-link rounded">
                        <i class="nav-icon bi bi-tags"></i>
                        <p>Category Management <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>

                    <ul class="nav nav-treeview ps-3">
                        <li class="nav-item">
                            <a href="{{ route('all.category.now') }}" class="nav-link">
                                <i class="bi bi-list"></i>
                                <p>All Categories</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('show.category.now') }}" class="nav-link">
                                <i class="bi bi-plus-circle"></i>
                                <p>Add Category</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

        </nav>
    </div>
</aside>
