<nav class="sidebar sidebar-offcanvas" id="sidebar">

    <ul id="accordion" class="accordion">
        <li class="{{Route::currentRouteName()=='dashboard'?'open':''}}">
            <div class="link"><a href="{{route('dashboard')}}"><i class="fa fa-tachometer"></i>Dashboard</a></div>
        </li>
        @if(auth()->user()->user_type=='S')
        <!-- <li class="{{Route::currentRouteName()=='usersManage'?'open':''}}">
            <div class="link"><a href="{{route('usersManage')}}"><i class="fa fa-user"></i>Users </a></div>
        </li> -->
        @endif
        <li class="{{Route::currentRouteName()=='memberManage'?'open':''}}">
            <div class="link"><a href="{{route('memberManage')}}"><i class="fa fa-users"></i>Members </a></div>
        </li>
        <li
            class="{{Route::currentRouteName()=='supplierManage'||Route::currentRouteName()=='categoryManage' ||Route::currentRouteName()=='productManage'?'open':''}}">
            <div class="link"><i class="fa fa-tasks"></i>Manage<i class="fa fa-chevron-down"></i></div>
            <ul class="submenu"
                style="{{Route::currentRouteName()=='supplierManage'||Route::currentRouteName()=='categoryManage' ||Route::currentRouteName()=='productManage'?'display: block;':''}}">
                <li><a href="{{route('supplierManage')}}"> <i class="fa fa-industry"></i>Supplier</a></li>
                <li><a href="{{route('categoryManage')}}"> <i class="fa fa-list-alt"></i>Category </a></li>
                <li><a href="{{route('productManage')}}"> <i class="fa fa-list-alt"></i>Product</a></li>
            </ul>
        </li>


        <li class="{{Route::currentRouteName()=='purchaseManage'||Route::currentRouteName()=='paymentManage' ||
                Route::currentRouteName()=='saleManage'||Route::currentRouteName()=='receiveManage'?'open':''}}">
            <div class="link"><i class="fa fa-exchange"></i>Transaction<i class="fa fa-chevron-down"></i></div>
            <ul class="submenu"
                style="{{Route::currentRouteName()=='purchaseManage'||Route::currentRouteName()=='paymentManage' 
                    ||Route::currentRouteName()=='saleManage' ||Route::currentRouteName()=='receiveManage'?'display: block;':''}}">
                <li><a href="{{route('purchaseManage')}}"><i class="fa fa-industry"></i>Purchase</a></li>
                <!-- <li><a href="{{route('paymentManage')}}"><i class="fa fa-list-alt"></i>Payment </a></li> -->
                <li><a href="{{route('saleManage')}}"><i class="fa fa-list-alt"></i>Sale</a></li>
                <!-- <li><a href="{{route('receiveManage')}}"><i class="fa fa-list-alt"></i>Receive</a></li> -->
                <li><a href="{{route('balanceManage')}}"><i class="fa fa-list-alt"></i>Payment/Receive</a></li>
            </ul>
        </li>

        <!-- <li class="{{Route::currentRouteName()=='accheadManage' ?'open':''}}">
            <div class="link"><i class="fa fa-exchange"></i>Finance<i class="fa fa-chevron-down"></i></div>
            <ul class="submenu" style="{{Route::currentRouteName()=='accheadManage'?'display: block;':''}}">
                <li><a href="{{route('accheadManage')}}"><i class="fa fa-industry"></i>Account Head</a></li>
                <li><a href="{{route('voucherManage')}}"><i class="fa fa-industry"></i>Voucher</a></li>
            </ul>
        </li> -->

        <!-- open -->
        <!-- display: block; -->
        <li
            class="{{Route::currentRouteName()=='memberReport'||Route::currentRouteName()=='stockReport' ||
                Route::currentRouteName()=='purchaseReport'||Route::currentRouteName()=='saleReport' ||
                Route::currentRouteName()=='receiveReport' ||Route::currentRouteName()=='supplierReport' ||Route::currentRouteName()=='paymentReport'?'open':''}}">
            <div class="link"><i class="fa fa-file"></i>Reports<i class="fa fa-chevron-down"></i></div>
            <ul class="submenu"
                style="{{Route::currentRouteName()=='memberReport'||Route::currentRouteName()=='stockReport' 
                    ||Route::currentRouteName()=='purchaseReport' ||Route::currentRouteName()=='saleReport' 
                    ||Route::currentRouteName()=='receiveReport' ||Route::currentRouteName()=='supplierReport' ||Route::currentRouteName()=='paymentReport'?'display: block;':''}}">
                <li><a href="{{route('memberReport')}}"><i class="fa fa-industry"></i>Member</a></li>
                <li><a href="{{route('stockReport')}}"><i class="fa fa-list-alt"></i>Stock </a></li>
                <li><a href="{{route('purchaseReport')}}"><i class="fa fa-list-alt"></i>Purchase</a></li>
                <li><a href="{{route('saleReport')}}"><i class="fa fa-list-alt"></i>Sale</a></li>
                <li><a href="{{route('paymentReport')}}"><i class="fa fa-list-alt"></i>Payment</a></li>
                <li><a href="{{route('receiveReport')}}"><i class="fa fa-list-alt"></i>Receive</a></li>
                <li><a href="{{route('supplierReport')}}"><i class="fa fa-list-alt"></i>Member/Nominal Purchase Sale</a>
                </li>
            </ul>
        </li>

        <!-- <li>
            <div class="link"><a href="{{route('memberReport')}}"><i class="fa fa-code"></i>Members Report </a>
            </div>
        </li>
         -->

        <!-- <li>
            <div class="link"><i class="fa fa-mobile"></i>Dropdown 1<i class="fa fa-chevron-down"></i></div>
            <ul class="submenu">
                <li><a href="#">Menu 1</a></li>
                <li><a href="#">Menu 2</a></li>
                <li><a href="#">Menu 3</a></li>
            </ul>
        </li> -->
        <!-- <li>
            <div class="link"><i class="fa fa-globe"></i>Dropdown 2<i class="fa fa-chevron-down"></i></div>
            <ul class="submenu">
                <li><a href="#">Menu 1</a></li>
                <li><a href="#">Menu 2</a></li>
                <li><a href="#">Menu 3</a></li>
            </ul>
        </li> -->
    </ul>
</nav>