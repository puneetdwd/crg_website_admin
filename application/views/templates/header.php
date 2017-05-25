<!-- BEGIN HEADER -->

<style>
.dropdown-backdrop {
    position: unset !important;
    z-index : -1 !important;
}
    
</style>
<?php $page = isset($page) ? $page : ''; ?>
<header class="page-header">
    <nav class="navbar mega-menu" role="navigation">
        <div class="container-fluid">
            <div class="clearfix navbar-fixed-top">
                <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="toggle-icon">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </span>
                </button>
                <!-- End Toggle Button -->
                <!-- BEGIN LOGO -->
                <a class="ir" href="<?php echo base_url(); ?>" id="logo" role="banner" title="Home" style="margin-top:0px;height:67px;"></a>
                
                <!-- END LOGO -->
                
                <!-- BEGIN TOPBAR ACTIONS -->
                <div class="topbar-actions">
                    <div style="text-align: right; margin-right: 10px;">
                        <span id="user-info">Welcome, <?php echo $this->session->userdata('name'); ?>
                        <?php if($this->product_id) { ?>
                            <small> &nbsp; [ <?php echo $this->session->userdata('user_type'); ?> - <?php echo $this->session->userdata('product_name'); ?> ]</small>
                        <?php }else if($this->user_type == 'Supplier') { ?>
                            <small> &nbsp; [ <?php echo $this->session->userdata('user_type'); ?> ]</small>
                        <?php }else if($this->user_type == 'Supplier Inspector') { ?>
                            <small> &nbsp; [ <?php echo $this->session->userdata('user_type'); ?> ]</small>
                        <?php } else { ?>
                            <small> &nbsp; [ Super Admin ]</small>
                        <?php } ?>
                        </span>
                    
                    </div>
                    <div>
                        
                        <ul class="user-info-links">
                            <?php $allowed_products = $this->session->userdata('products'); ?>
                            <?php if(count($allowed_products) > 1) { ?>
                                <li>
                                    <div class="btn-group">
                                        <a class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" href="javascript:;"> 
                                            Switch Product
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php foreach($allowed_products as $ap) { ?>
                                                <li>
                                                    <a href="<?php echo base_url().'users/switch_product/'.$ap['id']; ?>"> 
                                                        <?php echo $ap['name']; ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="<?php echo base_url(); ?>users/change_password" class="btn btn-link btn-sm">
                                    Change Password
                                </a>
                            </li>
                            <li>
                                <?php if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector'){ ?>
                                    <a href="<?php echo base_url(); ?>supplier_logout" class="btn btn-link btn-sm">
                                        Log Out 
                                    </a>
                                <?php }else{ ?>
                                    <a href="<?php echo base_url(); ?>logout" class="btn btn-link btn-sm">
                                        Log Out 
                                    </a>
                                <?php } ?>
                            </li>
                        </ul>
                        <div style="clear:both;"></div>
                    </div>
                </div>
                <!-- END TOPBAR ACTIONS -->
                
                <div class="page-logo-text page-logo-text-new text-left"></div>
            </div>
            <!-- BEGIN HEADER MENU -->
            <?php if(!isset($no_header_links)) { ?>
                <div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse header-nav-links">
                    <ul class="nav navbar-nav">
                        <li class="<?php if($page == '') { ?>active selected<?php } ?>">
                            <a href="<?php echo base_url(); ?>" target="_blank" class="text-uppercase">
                                <i class="icon-home"></i> Dashboard 
                            </a>
                        </li>
                        
                        <?php if($this->session->userdata('is_super_admin')) { ?>
                            <li class="dropdown more-dropdown <?php if($page == 'masters') { ?> active selected <?php } ?>">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> Masters 
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>users">
                                            <i class="icon-users"></i> Users 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>products">
                                            <i class="icon-briefcase"></i> Products
                                        </a>
                                    </li>
                                    <!--<li>
                                        <a href="<?php echo base_url(); ?>products/lines">
                                            <i class="icon-briefcase"></i> Products Lines
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>products/line_zones">
                                            <i class="icon-briefcase"></i> Line Zones
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>products/line_stages">
                                            <i class="icon-briefcase"></i> Line Stages & Devices
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>products/defect_code">
                                            <i class="icon-briefcase"></i> Defect Codes
                                        </a>
                                    </li>-->
                                </ul>
                            </li>
                        <?php } ?>
                        
                        <?php if($this->session->userdata('is_super_admin')) { ?>
                            
                            <!--<li class="dropdown more-dropdown">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> Upload Masters 
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>products/upload_defect_codes">
                                            <i class="icon-briefcase"></i> Upload Defect Codes 
                                        </a>
                                    </li>
                                </ul>
                            </li>-->
                        <?php } ?> 
                            
                        <?php if(!$this->session->userdata('is_super_admin')) { ?>
                            
                            <li class="<?php if($page == '') { ?>active selected<?php } ?>">
                                <a href="<?php echo base_url(); ?>dashboard/dashboard_screen" class="text-uppercase" target="_blank">
                                    <i class="icon-layers"></i> Dashboard Screen 
                                </a>
                                
                            </li>
                        <?php } ?> 
                        
                        <li class="dropdown more-dropdown <?php if($page == 'reports') { ?>active selected<?php } ?>">
                            <a href="javascript:;" class="text-uppercase">
                                <i class="icon-layers"></i> Reports 
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>reports/contact_us_report" target="_blank" class="text-uppercase">
                                        <i class="icon-layers"></i> Career & Contact Us Report
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>reports/leads_report" target="_blank" class="text-uppercase">
                                        <i class="icon-layers"></i> Leads Report
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>reports/mails_report" target="_blank" class="text-uppercase">
                                        <i class="icon-layers"></i> Mails Report
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li <?php if($page == 'configurations') { ?>active selected<?php } ?>">
                            <a href="<?php echo base_url(); ?>configurations" class="text-uppercase">
                                <i class="icon-layers"></i> Configurations 
                            </a>
                            
                        </li>
                    </ul>
                </div>
            <?php } ?>
            <!-- END HEADER MENU -->
        </div>
        <!--/container-->
    </nav>
</header>
<!-- END HEADER -->