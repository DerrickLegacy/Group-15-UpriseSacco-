<div class="bg-secondary pt-4 sidebar">
    <div>
        <div class="d-flex justify-content-center align-items-center">
            <div class="text-center pb-3 border-bottom">
                <img src="{{asset('images/Users.png')}}" alt="" class="profile-avatar">
                <h1 class="text-primary h3 text-uppercase mt-1">
                    Uprise Sacco
                </h1>
                <h5>Dashboard</h5>
            </div>
        </div>
        <div class="mt-4">
            <ul class="sidebar-nav">
                <li><a href="/admin"
                        class="d-flex align-items-center gap-1 {{request()->routeIs('admin.home') ? 'active' : ''}}">
                        <div><i class="feather-grid"></i></div>
                        <div class="ml-1">Home</div>
                    </a></li>
                <li><a href="/admin/deposits"
                        class="d-flex align-items-center gap-1 {{request()->routeIs('admin.deposits') ? 'active' : ''}}">
                        <div><i class="feather-upload"></i></div>
                        <div class="ml-1">Upload Deposits</div>

                    </a></li>
                <li><a href="/admin/requests"
                        class="d-flex align-items-center gap-1 {{request()->routeIs('admin.requests') ? 'active' : ''}}">
                        <div><i class="feather-user"></i></div>
                        <div class="ml-1">Pending Requests</div>

                    </a></li>
                <li><a href="/admin/reports"
                        class="d-flex align-items-center gap-1 {{request()->routeIs('admin.reports') ? 'active' : ''}}">
                        <div><i class="feather-file-text"></i></div>
                        <div class="ml-1">Reports</div>
                    </a>
                </li>
                <!-- <li><a href="/admin/alerts" Lambert
                        class="d-flex align-items-center gap-1 {{request()->routeIs('admin.alerts') ? 'active' : ''}}">
                        <div><i class="feather-info"></i></div>
                        <div class="ml-1">Alerts</div>
                    </a>
                </li> -->
                <li><a href="/admin/email-reports"
                        class="d-flex align-items-center gap-1 {{request()->routeIs('admin.email-reports') ? 'active' : ''}}">
                        <div><i class="feather-mail"></i></div>
                        <div class="ml-1"> Send Email Reports</div>
                    </a></li>
            </ul>
        </div>
    </div>
</div>