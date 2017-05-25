<div class="page-content">
    
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            
            <div class="row">
                
                <div class="col-md-12">
                
                <div class="col-md-12">
                    <div class="portlet light bordered">
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
                                                <th style="text-align:center;">Date</th>
                                                <th style="text-align:center;">Line Name</th>
                                                <th style="text-align:center;">Stage No.</th>
                                                <th style="text-align:center;">Stage Name</th>
                                                <th style="text-align:center;">Device No.</th>
                                                <th style="text-align:center;">Device Name</th>
                                                <th style="text-align:center;">Inspection Type</th>
                                                <th style="text-align:center;">Total Count</th>
                                                <!--<th class="no_sort">Action</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach($defects as $defect) { ?>
                                                <tr>
                                                    <td style="text-align:center;"><?php echo $i; ?></td>
                                                    <td nowrap style="text-align:center;"><?php echo date('jS M, y', strtotime($defect['StatusDt'])); ?></td>
                                                    <td style="text-align:center;"><?php echo $defect['line_name']; ?></td>
                                                    <td style="text-align:center;"><?php echo $defect['stage_no']; ?></td>
                                                    <td style="text-align:center;"><?php echo $defect['stage_name']; ?></td>
                                                    <td style="text-align:center;"><?php echo $defect['DeviceNo']; ?></td>
                                                    <td style="text-align:center;"><?php echo $defect['device_name']; ?></td>
                                                    <td style="text-align:center;"><?php echo $defect['DeviceStatus']; ?></td>
                                                    <td style="text-align:center;"><?php echo $defect['total_count']; ?></td>
                                                    
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
