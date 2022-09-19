<nav class="navBar fixed-top">
    <div class="float-left logo"><img src="{{ asset('publc/images/logo.png') }}" alt="" /></div>
    <div class="float-left navRightSec">
        <ul class="topDate">
            <!-- <li>Branch Name: Head Office</li>
            <li>KMS Year: 2020-21</li>
            <li>User: synergic</li>
            <li>Module: Paddy Procurement</li> -->
        </ul>
        <ul class="nav topDateRight">
            <!-- <li class="nav-item dropdown">
                <a href="#" class="nav-link"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>

            </li> -->
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{auth()->guard('admin')->user()->name}}</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item"><i class="fa fa-cog"></i> Settings</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <input type="submit" value="submit" hidden>
                        <a href="javascript:void(0)" onclick="event.preventDefault();this.closest('form').submit();"
                        class="dropdown-item"><i class="fa fa-sign-out"></i> Log Out</a>
                    </form>
                    
                </div>
            </li>
            <!-- <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Main Menu 2</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item">Dropdown Menu 1</a>
                    <a href="#" class="dropdown-item">Dropdown Menu 2</a>
                    <a href="#" class="dropdown-item">Dropdown Menu 3</a>
                    <a href="#" class="dropdown-item">Dropdown Menu 4</a>

                </div>
            </li> -->
            <!-- <li class="nav-item dropdown">
                <a href="#" class="nav-link"><i class="fa fa-bell" aria-hidden="true"></i> Notification</a>

            </li> -->
        </ul>

    </div>
</nav>