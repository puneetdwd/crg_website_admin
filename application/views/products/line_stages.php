<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Line Stages
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."products/line_stages"; ?>">
                    Manage Line Stages
                </a>
            </li>
            <li class="active">Manage Line Stages</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-offset-1 col-md-10">

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

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>
                        <?php if($this->product_id) { ?>
                            Line Stages
                        <?php } else { ?>
                            Line stages for product - <?php echo $product['name'];?>
                        <?php } ?>
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."products/add_line_stage/".$product['id']; ?>">
                            <i class="fa fa-plus"></i> Add New Stage
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($stages)) { ?>
                        <p class="text-center">No Stage exists yet.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Line Name</th>
                                    <th>Zone Name</th>
                                    <th>Stage No.</th>
                                    <th>Stage Name</th>
                                    <th>Device No.</th>
                                    <th>Device Name</th>
                                    <th class="no_sort" style="width:100px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($stages as $stage) { ?>
                                    <tr>
                                        <td><?php echo $stage['line_name']; ?></td>
                                        <td><?php echo $stage['zone_name']; ?></td>
                                        <td><?php echo $stage['stage_no']; ?></td>
                                        <td><?php echo $stage['stage_name']; ?></td>
                                        <td><?php echo $stage['device_no']; ?></td>
                                        <td><?php echo $stage['device_name']; ?></td>
                                        <td nowrap>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."products/add_line_zone/".$stage['id'];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            
                                            <a class="btn btn-xs btn-outline sbold red-thunderbird" data-confirm="Are you sure you want to delete this zone?"
                                                href="<?php echo base_url()."products/delete_line_stage/".$stage['id'];?>">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                    
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>