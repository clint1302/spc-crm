<div id="mainMenu">
    <ul class="sidebar-menu" data-widget="tree">
        <!--<li class="header">&nbsp;</li>-->
        <li><a href="{{ url('/dashboard')}}"><i class="fa fa-dashboard text-purple"></i> <span>Dashboard</span></a></li>
        
        <!---->
        @permission('crm-setting')
        <li class="treeview">
            <a href="#">
                <i class="fa fa-cog text-purple"></i> <span>Setting</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <!--<li><a href="#"><i class="fa fa-circle-o"></i> General Setting</a></li>-->
                <li><a href="{{ url('/setting/sms-setting') }}"><i class="fa fa-circle-o"></i> SMS</a></li>
                <li><a href="{{ url('/setting/job-types') }}"><i class="fa fa-circle-o"></i> Manage Job Types</a></li>
                <li><a href="{{ url('/setting/client-types') }}"><i class="fa fa-circle-o"></i> Manage Client Types</a></li>
                <li><a href="{{ url('/setting/contracts') }}"><i class="fa fa-circle-o"></i> Manage Contracts</a></li>
                <li><a href="{{ url('/setting/departments') }}"><i class="fa fa-circle-o"></i> Manage Departments</a></li>
                <!--<li><a href="{{ url('/setting/designations') }}"><i class="fa fa-circle-o"></i> Manage Designations</a></li>-->
                <li><a href="{{ url('/setting/enquiry-types') }}"><i class="fa fa-circle-o"></i> Manage Enquiry Types</a></li>
                @permission('role')
                <li><a href="{{ route('setting.role.index') }}"><i class="fa fa-circle-o"></i>Manage Roles</a></li>
                @endpermission
            </ul>
        </li>
        @endpermission

        <!---->

        @permission('our-team')
        <li class="treeview">
            <a href="#">
                <i class="fa fa-user text-purple"></i> <span>Peoples</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @permission('manage-team')
                <li><a href="{{ url('/people/employees') }}"><i class="fa fa-circle-o"></i> Manage Employee</a></li>
                @endpermission
                @permission('manage-clients')
                <li><a href="{{ url('/people/clients') }}"><i class="fa fa-circle-o"></i> Manage Clients</a></li>
                @endpermission
                @permission('manage-references')
                <li><a href="{{ url('/people/references') }}"><i class="fa fa-circle-o"></i> Manage References</a></li>
                @endpermission
            </ul>
        </li>
        @endpermission

        @permission('jobs')
        <li class="treeview">
            <a href="#">
                <i class="fa fa-briefcase text-purple"></i> <span>Jobs</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @permission('manage-jobs')
                <li><a href="{{ url('/jobs')}}"><i class="fa fa-circle-o"></i> Manage Jobs</a></li>
                @endpermission
                @permission('my-jobs')
                <li><a href="{{ url('/jobs/my-jobs') }}"><i class="fa fa-circle-o"></i> My Jobs</a></li>
                @endpermission
            </ul>
        </li>
        @endpermission

        @permission('report')
        <li class="treeview">
            <a href="#">
                <i class="fa fa-files-o text-purple"></i> <span>Report</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @permission('account-report')
                <li><a href="{{ url('/reports/account-reports') }}"><i class="fa fa-circle-o"></i> All Clients Reports</a></li>
                <li><a href="{{ url('/reports/clientaccount-reports') }}"><i class="fa fa-circle-o"></i> Client Reports</a></li>
                @endpermission
                @permission('job-report')
                <li><a href="{{ url('/reports/job-reports') }}"><i class="fa fa-circle-o"></i> Job Reports</a></li>
                @endpermission
                @permission('task-report')
                <li><a href="{{ url('/reports/task-reports') }}"><i class="fa fa-circle-o"></i> Task Reports</a></li>
                @endpermission
            </ul>
        </li>
        @endpermission

         <!--
        @permission('file-upload')
       <li><a href="{{ url('/folders')}}"><i class="fa fa-cloud-upload text-purple"></i> <span>File Upload</span></a></li>
        @endpermission

        @permission('bill')
        <li><a href="{{ url('/custom-invoice')}}"><i class="fa fa-file text-purple"></i> <span>Bill</span></a></li>
        @endpermission-->

        @permission('sms')
        <li><a href="{{ url('/sms')}}"><i class="fa fa-envelope text-purple"></i> <span>SMS</span></a></li>
        @endpermission

    <li class="header">PROFILE SETTING</li>
    <li><a href="{{ url('/profile/user-profile') }}"><i class="fa fa-user text-purple"></i> <span>Profile</span></a></li>
    <li><a href="{{ url('/profile/change-password') }}"><i class="fa fa-key text-purple"></i> <span>Change Password</span></a></li>
    <!--<li>
        <a href="{{ route('logout') }}"><i class="fa fa-lock text-purple"></i> <span>Logout</span></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>-->
</ul>
</div>