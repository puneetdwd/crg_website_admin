<div class="page-content">
    
    <div class="row">
        <div class="col-md-12">
            
            <div class="row">
                
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-body">
                            <?php if(empty($reports)) { ?>
                                <p class="text-center">No Data.</p>
                            <?php } else { ?>
                                <table class="table table-hover table-light">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Sr. No.</th>
                                            <th style="text-align:center;">Type</th>
                                            <th style="text-align:center;">Name</th>
                                            <th style="text-align:center;"> Business Email</th>
                                            <th style="text-align:center;">Company Name</th>
                                            <th style="text-align:center;">Mobile</th>
                                            <th style="text-align:center;">Date</th>
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
                                                <td style="text-align:center;"><?php echo $report['datetime']; ?></td>
                                            </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
