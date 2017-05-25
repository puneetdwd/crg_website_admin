<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($configuration) ? 'Edit': 'Add'); ?> Configuration
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."configurations"; ?>">Manage Configurations</a>
            </li>
            <li class="active"><?php echo (isset($configuration) ? 'Edit': 'Add'); ?> Configuration</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered configuration-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Configuration form
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

                            <?php if(isset($configuration['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $configuration['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Name:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="name" placeholder="Name *"
                                        value="<?php echo isset($configuration['name']) ? $configuration['name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="mail">Email:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="mail" placeholder="Email *"
                                        value="<?php echo isset($configuration['email']) ? $configuration['email'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="cc">CC:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="cc" placeholder="CC *"
                                        value="<?php echo isset($configuration['cc']) ? $configuration['cc'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="bcc">BCC:</label>
                                        <input type="text" class="form-control" name="bcc" placeholder="BCC"
                                        value="<?php echo isset($configuration['bcc']) ? $configuration['bcc'] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="configuration-sel-product-error">
                                        <label class="control-label">Select Product:</label>

                                        <select name="product" class="form-control select2me" data-placeholder="Select Product" data-error-container="#configuration-sel-product-error">
                                            <?php $product = isset($configuration['product']) ? $configuration['product'] : ''; ?>
                                            <option value=""></option>
                                            <option value="Customs" <?php if($product == 'Custom') { ?> selected="selected" <?php } ?>>
                                                Custom
                                            </option>
                                            <option value="Datawatch" <?php if($product == 'Datawatch') { ?> selected="selected" <?php } ?>>
                                                Datawatch
                                            </option>
                                            <option value="Atlassian" <?php if($product == 'Atlassian') { ?> selected="selected" <?php } ?>>
                                                Atlassian
                                            </option>
                                            <option value="Subscribe" <?php if($product == 'Subscribe') { ?> selected="selected" <?php } ?>>
                                                Subscribe
                                            </option>
                                            <option value="Contact Us" <?php if($product == 'Contact Us') { ?> selected="selected" <?php } ?>>
                                                Contact Us
                                            </option>
                                            <option value="Career" <?php if($product == 'Career') { ?> selected="selected" <?php } ?>>
                                                Career
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'configurations'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>