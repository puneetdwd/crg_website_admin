<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($line) ? 'Edit': 'Add'); ?> Line Zone
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."products/lines"; ?>">
                    Manage Lines 
                </a>
            </li>
            <li>
                <a href="<?php echo base_url()."products/line_zones/"; ?>">
                    Manage Line Zones
                </a>
            </li>
            <li class="active"><?php echo (isset($line) ? 'Edit': 'Add'); ?> Line Zone</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        
            <div class="portlet light bordered checkpoint-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Line Zone Form - <?php echo $product['name']; ?>
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" class="validate-form" method="post">
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <i class="fa fa-times"></i>
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>

                            <?php if(isset($zone['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $zone['id']; ?>" />
                            <?php } ?>
                                
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Line:
                                        <span class="required">*</span></label>
                                        <select name="line_id" id="add-user-zone" class="form-control required select2me"
                                                data-placeholder="Select Line" data-error-container="#user-admin-error" required>
                                            <?php $line_id = isset($zone['line_id']) ? $zone['line_id'] : '';?>
                                            <option value=""></option>
                                            <?php foreach($lines as $line) { ?>
                                            <option value="<?php echo $line['id'] ?>" <?php if($line_id == $line['id']) { echo "selected='selected'"; } ?>>
                                                <?php echo $line['name']; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Zone Name:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" required name="zone_name"
                                        value="<?php echo isset($zone['zone_name']) ? $zone['zone_name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'products/lines/'.$product['id']; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>