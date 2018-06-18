<ul class="nav-main">
    <li>
        <a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i><span
                    class="sidebar-mini-hide">Dashboard</span></a>
    </li>
    {{--<li>
        <a href="{{url('/admin/statistics')}}"><i class="fa fa-line-chart"></i><span
                    class="sidebar-mini-hide">Statistics</span></a>
    </li>--}}
    <li>
        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-users"></i><span
                    class="sidebar-mini-hide"> Users</span></a>
        <ul>
            <li>
                <a href="{{url('/admin/users/all')}}">View all Users</a>
            </li>
            <li>
                <a href="{{url('/admin/users/registered')}}">View Registered Users</a>
            </li>
            <li>
                <a href="{{url('/admin/users/unregistered')}}">View Unregistered Users</a>
            </li>
            <li>
                <a href="{{url('/admin/users/active')}}">View Active Users</a>
            </li>
            <li>
                <a href="{{url('/admin/users/suspended')}}">View Suspended Users</a>
            </li>
            <li>
                <a href="{{url('/admin/users/blocked')}}">View Blocked Users</a>
            </li>
        </ul>
    </li>
    <li>
        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-plus"></i><span
                    class="sidebar-mini-hide"> Add New</span></a>
        <ul>
            <li>
                <a href="{{url('/admin/add/admin')}}">New Admin</a>
            </li>
            <li>
                <a href="{{url('/admin/add/user')}}">New User</a>
            </li>
        </ul>
    </li>
    <li>
        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-fire"></i><span
                    class="sidebar-mini-hide"> Transactions</span></a>
        <ul>
            <li>
                <a href="{{url('/admin/transactions/share')}}">Share PNM</a>
            </li>
            <li>
                <a href="{{url('/admin/transactions/withdrawal/pnm')}}">Approve PNM Withdrawals</a>
            </li>
            <li>
                <a href="{{url('/admin/transactions/withdrawal/ngn/student')}}">Approve Student NGN Withdrawal</a>
            </li>
            <li>
                <a href="{{url('/admin/transactions/withdrawal/ngn/staff')}}">Approve Staff NGN Withdrawal</a>
            </li>
            <li>
                <a href="{{url('/admin/transactions/withdrawal/ngn/partner')}}">Approve Partner NGN Withdrawal</a>
            </li>
            <li>
                <a href="{{url('/admin/transactions/verified/pnm')}}">Verified PNM Withdrawals</a>
            </li>
            <li>
                <a href="{{url('/admin/transactions/verified/ngn')}}">Verified NGN Withdrawal</a>
            </li>
            <li>
                <a href="{{url('/admin/transactions/history')}}">History</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{url('/admin/settings')}}"><i class="fa fa-line-chart"></i><span
                    class="sidebar-mini-hide">Settings</span></a>
    </li>
</ul>