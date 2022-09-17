<div class="main-sidebar sidebar-style-3">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('/') }}">Logo</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index-2.html">CP</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ route('dashboard') ? '' : 'dropdown active' }}"><a class="nav-link" href="#"><i
                        class="fas fa-fire"></i>
                    <span>Dashboard</span></a></li>

            <li class="menu-header">Starter</li>
            {{-- <li><a class="nav-link" href="blank.html"><i class="fas fa-users"></i> <span>User</span></a></li> --}}
            <li class="{{ request()->segment(1) == 'posts' ? 'dropdown active' : '' }}"><a class="nav-link"
                    href="{{ route('posts') }}"><i class="fas fa-th-list"></i> <span>Posts</span></a>
            </li>
            <li class="{{ request()->segment(1) == 'comments' ? 'dropdown active' : '' }}"><a class="nav-link"
                    href="{{ route('comments') }}"><i class="fas fa-comment-alt"></i>
                    <span>Comments</span></a>
            </li>
        </ul>
    </aside>
</div>
