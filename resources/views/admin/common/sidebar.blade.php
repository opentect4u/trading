<nav class="sidebar sidebar-offcanvas" id="sidebar">

    <ul id="accordion" class="accordion">
        <li class="{{Route::currentRouteName()=='admin.dashboard'?'open':''}}">
            <div class="link"><a href="{{route('admin.dashboard')}}"><i class="fa fa-tachometer"></i>Dashboard</a></div>
        </li>
        
        <li class="{{Route::currentRouteName()=='admin.SocietyManage'?'open':''}}">
            <div class="link"><a href="{{route('admin.SocietyManage')}}"><i class="fa fa-tachometer"></i>Society Manage</a></div>
        </li>
        <li class="{{Route::currentRouteName()=='admin.userManage'?'open':''}}">
            <div class="link"><a href="{{route('admin.userManage')}}"><i class="fa fa-tachometer"></i>User Manage</a></div>
        </li>
        <!-- <li
            class="{{Route::currentRouteName()=='supplierManage'||Route::currentRouteName()=='categoryManage' ||Route::currentRouteName()=='productManage'?'open':''}}">
            <div class="link"><i class="fa fa-tasks"></i>Manage<i class="fa fa-chevron-down"></i></div>
            <ul class="submenu"
                style="{{Route::currentRouteName()=='supplierManage'||Route::currentRouteName()=='categoryManage' ||Route::currentRouteName()=='productManage'?'display: block;':''}}">
                <li><a href="{{route('supplierManage')}}"> <i class="fa fa-industry"></i>Supplier</a></li>
                <li><a href="{{route('categoryManage')}}"> <i class="fa fa-list-alt"></i>Category </a></li>
                <li><a href="{{route('productManage')}}"> <i class="fa fa-list-alt"></i>Product</a></li>
            </ul>
        </li> -->
       
        <!-- <li>
            <div class="link"><a href="{{route('memberReport')}}"><i class="fa fa-code"></i>Members Report </a>
            </div>
        </li>

        <li>
            <div class="link"><a href="{{route('paymentReport')}}"><i class="fa fa-code"></i>Payment Report </a>
            </div>
        </li>
        <li>
            <div class="link"><a href="{{route('receiveReport')}}"><i class="fa fa-code"></i>Receive Report </a>
            </div>
        </li>

        <li>
            <div class="link"><a href="{{route('supplierReport')}}"><i class="fa fa-code"></i>Supplier Purchase Sale
                    Report </a>
            </div>
        </li> -->


    </ul>
</nav>