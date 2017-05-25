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
                                            <th style="text-align:center;">To</th>
                                            <th style="text-align:center;"> CC Email</th>
                                            <th style="text-align:center;">BCC </th>
                                            <th style="text-align:center;">Attachment</th>
                                            <th style="text-align:center;">Status</th>
                                            <th style="text-align:center;">Send On</th>
                                            <th style="text-align:center;">Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($reports as $report) { ?>
                                            <tr>
                                                <td style="text-align:center;"><?php echo $i; ?></td>
                                                <td style="text-align:center;"><?php echo $report['to_email']; ?></td>
                                                <td style="text-align:center;"><?php echo $report['cc_email']; ?></td>
                                                <td style="text-align:center;"><?php echo $report['bcc_email']; ?></td>
                                                <td style="text-align:center;"><?php echo $report['attachment']; ?></td>
                                                <td style="text-align:center;"><?php echo $report['status']; ?></td>
                                                <td style="text-align:center;"><?php echo $report['created_datetime']; ?></td>
                                                <td style="text-align:center;"><?php echo $report['message']; ?>
                                                </td>
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