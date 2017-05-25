<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($line) ? 'Edit': 'Add'); ?> Stages
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."products/line_zones"; ?>">
                    Manage Zones
                </a>
            </li>
            <li>
                <a href="<?php echo base_url()."products/line_stages"; ?>">
                    Manage Stages
                </a>
            </li>
            <li class="active"><?php echo (isset($line) ? 'Edit': 'Add'); ?> Stages</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        
            <div class="portlet light bordered checkpoint-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Stage Form - <?php echo $product['name']; ?>
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
                                <div class="col-md-6">
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
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Zone Name:
                                        <span class="required">*</span></label>
                                        <select name="zone_id" id="add-user-zone" class="form-control required select2me"
                                                data-placeholder="Select Zone" data-error-container="#user-admin-error" required>
                                            <?php $zone_id = isset($zone['zone_id']) ? $zone['zone_id'] : '';?>
                                            <option value=""></option>
                                            <?php foreach($zones as $zone) { ?>
                                            <option value="<?php echo $zone['id'] ?>" <?php if($zone_id == $zone['id']) { echo "selected='selected'"; } ?>>
                                                <?php echo $zone['zone_name']; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Stage No.:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" required name="stage_no"
                                        value="<?php echo isset($stage['stage_no']) ? $stage['stage_no'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Stage Name :
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" required name="stage_name"
                                        value="<?php echo isset($stage['stage_name']) ? $stage['stage_name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Device No.:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" required name="device_no"
                                        value="<?php echo isset($zone['device_no']) ? $zone['device_no'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Device Name :
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" required name="device_name"
                                        value="<?php echo isset($zone['device_name']) ? $zone['device_name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'products/line_stages'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>