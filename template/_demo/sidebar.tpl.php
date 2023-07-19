
<div id="sidebar">
    <div class="row">

        <ul class="nav nav-sidebar">
            <li class="overview<?php if($nav == 'overview') echo ' active'; ?>">
                <a href="<?php echo BASE_URL; ?>?module=overview" data-pjax-container="#main"><span class="glyphicon glyphicon-dashboard"></span>Dashboard</a>
            </li>
            <li class="nouse<?php if($nav == 'nouse') echo ' active'; ?>">
                <a href="<?php echo BASE_URL; ?>?module=nouse" data-pjax-container="#main"><span class="glyphicon glyphicon-picture"></span>Banner</a>
            </li>
        </ul>

        <ul class="nav nav-sidebar">
            <li class="simple<?php if($nav == 'simple') echo ' active'; ?>">
                <a href="<?php echo BASE_URL; ?>?module=simple" data-pjax-container="#main"><span class="glyphicon glyphicon-map-marker" title="Simple Demo"></span>Point</a>
            </li>
            <li class="advanced<?php if($nav == 'advanced') echo ' active'; ?>">
                <a href="<?php echo BASE_URL; ?>?module=advanced" data-pjax-container="#main"><span class="glyphicon glyphicon-bed" title="Advance Demo"></span>Product</a>
            </li>
        </ul>

        <ul class="nav nav-sidebar">
            <li class="user<?php if($nav == 'user') echo ' active'; ?>">
                <a href="javascript:;" data-pjax-container="#main"><span class="glyphicon glyphicon-user"></span>User</a>
            </li>
        </ul>

        <ul class="nav nav-sidebar">
            <li class="admin<?php if($nav == 'admin') echo ' active'; ?>">
                <a href="javascript:;" data-pjax-container="#main"><span class="glyphicon glyphicon-asterisk"></span>Administror</a>
            </li>
        </ul>

    </div>
</div>
