<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Configurations
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Manage Configurations</li>
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
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-reorder"></i>List of Configurations
                            </div>

                            <div class="actions">
                                <a class="button normals btn-circle" href="<?php echo base_url()."configurations/add"; ?>">
                                    <i class="fa fa-download"></i> Add Configuration
                                </a>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <?php if(empty($configurations)) { ?>
                                <p class="text-center">No Configuration yet.</p>
                            <?php } else { ?>
                                <div class="table-responsive">
                                <table class="table table-hover table-light">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Sr. No.</th>
                                            <th style="text-align:center;">Name</th>
                                            <th style="text-align:center;">Email</th>
                                            <th style="text-align:center;">CC</th>
                                            <th style="text-align:center;">BCC</th>
                                            <th style="text-align:center;">Product</th>
                                            <th class="no_sort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($configurations as $configuration) { ?>
                                            <tr>
                                                <td style="text-align:center;"><?php echo $i; ?></td>
                                                <td style="text-align:center;"><?php echo $configuration['name']; ?></td>
                                                <td style="text-align:center;"><?php echo $configuration['email']; ?></td>
                                                <td style="text-align:center;"><?php echo $configuration['cc']; ?></td>
                                                <td style="text-align:center;"><?php echo $configuration['bcc']; ?></td>
                                                <td style="text-align:center;"><?php echo $configuration['product']; ?></td>
                                                <td>
                                                    <a class="button small gray" href="<?php echo base_url()."configurations/add/".$configuration['id']; ?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    
                                                    <a class="button small gray" data-confirm="Are you sure you want to delete this configuration?" href="<?php echo base_url()."configurations/delete/".$configuration['id']; ?>">
                                                        <i class="fa fa-trash-o"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                                </div>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
