<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            View Careers/Contacts Us
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">View Report</li>
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
                            <form role="form" class="validate-form" method="post">
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
                                    
                                    <input type="hidden" id="page-no" name="page_no" value="1"/>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Date Range</label>
                                                <div class="input-group date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                                    <input type="text" class="form-control" name="start_range" 
                                                    value="<?php echo $this->input->post('start_range'); ?>">
                                                    <span class="input-group-addon">
                                                    to </span>
                                                    <input type="text" class="form-control" name="end_range"
                                                    value="<?php echo $this->input->post('end_range'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!--<div class="col-md-6">
                                            <div class="form-group" id="report-sel-part-error">
                                                <label class="control-label">Select Line:</label>
                                                        
                                                <select name="line_id" class="form-control select2me"
                                                    data-placeholder="Select Line" data-error-container="#report-sel-part-error">
                                                    <option></option>
                                                    <?php foreach($lines as $line) { ?>
                                                        <option value="<?php echo $line['id']; ?>" <?php if($line['id'] == $this->input->post('line_id')) { ?> selected="selected" <?php } ?>>
                                                            <?php echo $line['name']; ?>
                                                        </option>
                                                    <?php } ?>        
                                                </select>
                                            </div>
                                        </div>-->
                                        
                                        

                                    <?php if($this->user_type == 'Admin' || $this->user_type == 'LG Inspector'){ ?>
                                        <!--<div class="col-md-4">
                                            <div class="form-group" id="report-sel-supplier-error">
                                                <label class="control-label" for="supplier_id">Supplier:</label>
                                                
                                                <select name="supplier_id" class="form-control select2me"
                                                data-placeholder="Select Supplier" data-error-container="#report-sel-supplier-error">
                                                    <option value=""></option>
                                                    
                                                    <?php $sel_supplier = $this->input->post('supplier_id'); ?>
                                                    <?php foreach($suppliers as $supplier) { ?>
                                                        <option value="<?php echo $supplier['id']; ?>" 
                                                        <?php if($sel_supplier == $supplier['id']) { ?> selected="selected" <?php } ?>>
                                                            <?php echo $supplier['supplier_no'].' - '.$supplier['name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                    
                                                </select>
                                            </div>
                                        </div>-->
                                    <?php } ?>
                                    
                                </div>
                                
                                <div class="form-actions">
                                    <?php /*if($this->session->userdata('is_super_admin')){ ?>
                                        <label class="control-label" for="supplier_id">All Product:</label>
                                        <input type="checkbox" name="product_all" class="form-control" value="all" 
                                        <?php if($this->input->post('product_all') == 'all'){echo "checked";} ?> />
                                    <?php }*/ ?>
                                    <button class="button" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-reorder"></i>List of Contacts
                            </div>
                            <?php if(!empty($defects)) { ?>
                            <div class="actions">
                                <a class="button normals btn-circle" href="<?php echo base_url()."reports/excel_export/defect_report"; ?>">
                                    <i class="fa fa-download"></i> Export Report
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="portlet-body">
                            <?php if(empty($defects)) { ?>
                                <p class="text-center">No Data For Selected Filters.</p>
                            <?php } else { ?>
                                <div class="pagination-sec pull-right"></div>
                                <div style="clear:both;"></div>
                                
                                <!--<div class="table-scrollable">-->
                                    <table class="table table-hover table-light">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">Sr.No.</th>
                                                <th style="text-align:center;">Type</th>
                                                <th style="text-align:center;">Name</th>
                                                <th style="text-align:center;">Email</th>
                                                <th style="text-align:center;">Subject</th>
                                                <th style="text-align:center;">Mobile</th>
                                                <th style="text-align:center;">Comment</th>
                                                <th style="text-align:center;">CV Name</th>
                                                
                                                <!--<th class="no_sort">Action</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach($rows as $row) { ?>
                                                <tr>
                                                    <td style="text-align:center;"><?php echo $i; ?></td>
                                                    <td nowrap style="text-align:center;"><?php echo date('jS M, y', strtotime($defect['StatusDt'])); ?></td>
                                                    <td style="text-align:center;"><?php echo $row['line_name']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['name']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['email']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['subject']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['mobile']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['comment']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['cv_name']; ?></td>
                                                    
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
