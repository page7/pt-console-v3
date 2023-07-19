<header id="header" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="sidebar-toggle visible-xs-inline-block" data-toggle="sidebar" data-target="#sidebar">
                <span class="icon"><?php echo _('menu'); ?></span>
            </button>

            <span class="navbar-brand">
                <a class="hidden-xs" href="<?php echo BASE_URL; ?>" data-pjax-container="#main"><?php echo config('web.title'); ?> <span class="label label-sm version"><?php echo config('web.version'); ?></span></a>
                <strong class="visible-xs-inline-block"><?php echo config('web.title_abbr'); ?><em class="label label-sm version"><?php echo config('web.ver'); ?></em></strong>
            </span>

            <!--button id="navbar-toggle" type="button" class="navbar-toggle" data-toggle="dropdown" data-target=".navbar-collapse">
                <span class="icon"><?php echo _('more_vert'); ?></span>
            </button-->
        </div>

        <div class="navbar-search input-group hidden-lg hidden-md hidden-sm">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="icon"><?php echo _('Search'); ?></span></button>
            </span>
            <input type="text" class="form-control" style="display:none;" placeholder="<?php echo _('Search for...'); ?>">
        </div>

        <div class="navbar-collapse dropdown" aria-labelledby="navbar-toggle">
            <ul class="nav navbar-nav navbar-right dropdown-menu">
                <li><a href="<?php echo BASE_URL; ?>?module=setting" data-pjax-container="#main"><?php echo _('Setting'); ?></a></li>
                <li><a href="<?php echo BASE_URL; ?>?module=login&operate=logout" data-pjax-container="#main"><?php echo _('Logout'); ?></a></li>
            </ul>
        </div>
    </div>
</header>
