
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Career & Contact Us Report
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Career & Contact Us Report</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <?php if($this->session->flashdata('error')) {?>
                <div class="alert alert-danger">
                   <i class="fa fa-times"></i>
                   <?php echo $this->session->flashdata('error');?>
                </div>
            <?php } else if($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">
                    <i class="fa fa-check"></i>
                   <?php echo $this->session->flashdata('success');?>
                </div>
            <?php } ?>
            
            <div class="row">
                
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-body form">
                            <form role="form" class="validate-form" method="get">
                                <div class="form-body" style="padding:0px;">
                                    <div class="alert alert-danger display-hide">
                                        <button class="close" data-close="alert"></button>
                                        You have some form errors. Please check below.
                                    </div>
                                
                                
                                    <?php if(isset($error)) { ?>
                                        <div class="alert alert-danger">
                                            <?php echo $error; ?>
                                        </div>
                                    <?php } ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" id="report-sel-date-type-error">
                                                <label class="control-label">Select Date Type:</label>

                                                <select name="date_type" class="form-control select2me" data-placeholder="Select Date Type" data-error-container="#report-sel-date-type-error">
                                                    <?php $date_type = $this->input->get('date_type');?>
                                                    <option value=""></option>
                                                    <option value="Q1" <?php if($date_type == 'Q1') { ?> selected="selected" <?php } ?>>
                                                        Quarter 1 (01 Apr - 30 Jun)
                                                    </option>
                                                    <option value="Q2" <?php if($date_type == 'Q2') { ?> selected="selected" <?php } ?>>
                                                        Quarter 2 (01 Jul - 30 Sep)
                                                    </option>
                                                    <option value="Q3" <?php if($date_type == 'Q3') { ?> selected="selected" <?php } ?>>
                                                        Quarter 3 (01 Oct - 31 Dec)
                                                    </option>
                                                    <option value="Q4" <?php if($date_type == 'Q4') { ?> selected="selected" <?php } ?>>
                                                        Quarter 4 (01 Jan - 31 Mar)
                                                    </option>
                                                    <option value="H1" <?php if($date_type == 'H1') { ?> selected="selected" <?php } ?>>
                                                        Half-Year 1 (01 Apr - 30 Sep)
                                                    </option>
                                                    <option value="H2" <?php if($date_type == 'H2') { ?> selected="selected" <?php } ?>>
                                                        Half-Year 2 (01 Oct - 31 Mar )
                                                    </option>
                                                    <option value="Y" <?php if($date_type == 'Y') { ?> selected="selected" <?php } ?>>
                                                        Full Year (01 Apr - 31 Mar)
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" id="report-sel-year-error">
                                                <label class="control-label">Select Year:</label>

                                                <select name="year" class="form-control select2me" data-placeholder="Select Year" data-error-container="#report-sel-year-error">
                                                    <option value=""></option>
                                                    <?php $year = $this->input->get('year') ? $this->input->get('year') : date('Y'); ?>

                                                    <?php for($y = date('Y'); $y > (date('Y')-5); $y--) { ?>
                                                        <option value="<?php echo $y; ?>" <?php if($year == $y) { ?> selected="selected" <?php } ?>>
                                                            <?php echo $y; ?>
                                                        </option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Date Range</label>
                                                <div class="input-group date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                                    <input type="text" class="form-control" name="start_range" 
                                                    value="<?php echo $this->input->get('start_range'); ?>">
                                                    <span class="input-group-addon">
                                                    to </span>
                                                    <input type="text" class="form-control" name="end_range"
                                                    value="<?php echo $this->input->get('end_range'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group" id="report-sel-type-error">
                                                <label class="control-label">Select Type:</label>

                                                <select name="type" class="form-control select2me" data-placeholder="Select Line" data-error-container="#report-sel-type-error">
                                                    <option value="all"
                                                        <?php if($this->input->get('type') == 'all') { ?> selected="selected" <?php } ?>>
                                                        All
                                                    </option>
                                                    <option value="Contact Us"
                                                        <?php if($this->input->get('type') == 'Contact Us') { ?> selected="selected" <?php } ?>>
                                                        Contact Us
                                                    </option>
                                                    <option value="Career"
                                                        <?php if($this->input->get('type') == 'Career') { ?> selected="selected" <?php } ?>>
                                                        Career
                                                    </option>
                                                    <option value="Subscription"
                                                        <?php if($this->input->get('type') == 'Subscription') { ?> selected="selected" <?php } ?>>
                                                        Subscription
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="form-actions">
                                        <button class="button" type="submit">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-reorder"></i>Report
                            </div>

                            <?php if(!empty($reports)) { ?>
                                <div class="actions">
                                    <a class="button normals btn-circle" href="<?php echo base_url()."reports/excel_export_contact_us_report?".$_SERVER['QUERY_STRING']; ?>">
                                        <i class="fa fa-download"></i> Export Report
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="portlet-body">
                            <?php if(empty($reports)) { ?>
                                <p class="text-center">No Data.</p>
                            <?php } else { ?>
                                <div class="pagination-sec pull-right"></div>
                                <div style="clear:both;"></div>
                                
                                <!--<div class="table-scrollable">-->
                                    <table class="table table-hover table-light">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">Sr. No.</th>
                                                <th style="text-align:center;">Type</th>
                                                <th style="text-align:center;">Name</th>
                                                <th style="text-align:center;">Email</th>
                                                <th style="text-align:center;">Subject</th>
                                                <th style="text-align:center;">Mobile</th>
                                                <th style="text-align:center;">Comment</th>
                                                <th style="text-align:center;">Attachment</th>
                                                <th nowrap style="text-align:center;">Date</th>
                                                <th style="text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach($reports as $report) { ?>
                                                <tr>
                                                    <td style="text-align:center;"><?php echo $i; ?></td>
                                                    <td style="text-align:center;"><?php echo $report['type']; ?></td>
                                                    <td style="text-align:center;"><?php echo $report['name']; ?></td>
                                                    <td style="text-align:center;"><?php echo $report['email']; ?></td>
                                                    <td style="text-align:center;"><?php echo $report['subject']; ?></td>
                                                    <td style="text-align:center;"><?php echo $report['mobile']; ?></td>
                                                    <td style="text-align:center;"><?php echo $report['comment']; ?></td>
                                                    
                                                    <td style="text-align:center;">
                                                        <?php if($report['cv_name'] != 'NA') { ?>
                                                            <a href="<?php echo base_url(); ?>/assets/uploads/<?php echo $report['cv_name']; ?>" target="_blank"><?php echo $report['cv_name']; ?></a>
                                                        <?php } else { ?>
                                                            NA
                                                        <?php } ?>
                                                    </td>
                                                    
                                                    <td nowrap style="text-align:center;"><?php echo date('y-m-d H:i', strtotime($report['datetime'])); ?></td>
                                                    <td style="text-align:center;">
                                                        <?php if($report['type'] == 'Contact Us') { ?>
                                                            <a class="button small gray" href="<?php echo base_url(); ?>reports/delete_contact_us/<?php echo $report['id']; ?>" data-confirm="Are you sure you want to delete this record?">Delete</a>
                                                        
                                                        <?php } else if($report['type'] == 'Subscription') { ?>
                                                            <a class="button small gray" href="<?php echo base_url(); ?>reports/delete_subscription/<?php echo $report['id']; ?>" data-confirm="Are you sure you want to delete this record?">Delete</a>
                                                        <?php } else  { ?>
                                                            <a class="button small gray" href="<?php echo base_url(); ?>reports/delete_career/<?php echo $report['id']; ?>" data-confirm="Are you sure you want to delete this record?">Delete</a>    
                                                        <?php } ?>
                                                    </td>   
                                                </tr>
                                            <?php $i++; } ?>
                                        </tbody>
                                    </table>
                                <!--</div>-->
                                
                                <div class="pagination-sec pull-right"></div>
                                <div style="clear:both;"></div>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
</div>
<?php /*if(!empty($defects)) { ?>
    <script>
        $(window).load(function() {
            $('.check-judgement-button:first').trigger('click');
            
            $('.pagination-sec').bootpag({
                total: <?php echo $total_page; ?>,
                page: <?php echo $page_no; ?>,
                maxVisible: 5,
                leaps: true,
                firstLastUse: true,
                first: 'â†?',
                last: 'â†’',
                wrapClass: 'pagination',
                activeClass: 'active',
                disabledClass: 'disabled',
                nextClass: 'next',
                prevClass: 'prev',
                lastClass: 'last',
                firstClass: 'first'
            }).on("page", function(event, num){
                show_page(num); // or some ajax content loading...
            }); 
        });
    </script>
<?php }*/ ?>
