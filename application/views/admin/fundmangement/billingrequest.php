<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"></style>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<div class="page animsition">
    <div class="page-header">





        <div class="page-header">
            <h1 class="page-title"><?php echo $title; ?></h1>
            <div class="page-header-actions">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Home</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <?php echo $loadpage; ?>
                        </a>
                    </li>
                    <li class="active">
                        <?php echo $title; ?>
                    </li>
                </ol>
            </div>
        </div>

        <div class="page-content">
            <!-- Panel -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <p class="result-msg" style="text-align: center;color: green;font-size: 20px;display: none;"></p>
                <div class="secound">

                    <div class="fabb">
                        Date
                    </div>

                    <div class="fad">
                        To

                    </div>
                    <div class="fabb">
                        Date
                    </div>
                    <div class="faff">
                        SEARCH

                    </div>

                </div>


                <div class="third">

                    <div class="fab">
                        <div class="selector" id="uniform-user_type" style="width: 100px;">
                            <select id="user_type" name="user_type" class="form-control">
                                <option value="">ID</option>

                                <option value="3">
                                    Username</option>
                                <option value="2">Email</option>


                            </select>
                        </div>
                    </div>
                    <div class="fad">
                        <i class="fa fa-minus" aria-hidden="true"></i>

                    </div>
                    <div class="fae">


                    </div>
                    <div class="faf">
                        SEARCH

                    </div>

                </div>
                <div class="table">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><img src='<?php echo site_url("/assets/adminassets/images/box.png");?>'>
                                </th>
                                <th> No </th>
                                <th>CONTRACT
                                    <br/> ID</th>
                                <th> Transaction
                                    <br/> ID </th>

                                <th> Description </th>
                                <th> Transaction To </th>
                                <th> Transaction From </th>
                                <th> Transaction Through </th>
                                <th> Amount </th>
                                <th> Date </th>
                                <th> Status </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if( ! empty( $txns ) ): ?>
                                <?php foreach($txns as $key => $txn): ?>
                                    <tr>
                                        <td> <img src='<?php echo site_url("/assets/adminassets/images/box.png");?>'> </td>
                                        <td> <?= ( $key + 1 ) ?> </td>
                                        <td> <?= $txn->updated_at ?> </td>
                                        <td> <?= ( isset($txn->transaction_id) ? $txn->transaction_id : "" ) ?> </td>
                                        <td> 
                                            <?php
                                                $job_amount  = ( isset($txn->offer_bid_amount) ? $txn->offer_bid_amount : $txn->bid_amount );
                                                $nb_hour     =  $txn->amount_due / $job_amount;
                                            ?> 
                                            <?= ( $nb_hour . 'hr * $' . $job_amount )  ?>
                                        </td>
                                        <td> <?= ( $txn->employer_fname . ' ' . $txn->employer_lname . '<br>' . $txn->employer_email )  ?> </td>
                                        <td> <?= ( $txn->freelancer_fname . ' ' . $txn->freelancer_lname . '<br>' . $txn->freelancer_email )  ?> </td>
                                        <td> <?= ( isset($txn->service_name) ? $txn->service_name : "" ) ?> </td>
                                        <td> <?= ('$' . $txn->amount_due) ?> </td>
                                        <td> <?= $txn->contact_id ?> </td>
                                        <td> <?= $txn->status ?> </td>
                                        <td>
                                            <div class="selector" id="uniform-user_type" style="width: 100px;">
                                                <select id="user_type" name="user_type" class="form-control">
                                                    <option value="">Edit</option>
                                                    <option value="3">Pending</option>
                                                    <option value="2">Processed</option>
                                                </select>
                                            </div>
                                            <h5> manually </h5>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="12"><b> No billing request yet. </b></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            bFilter: false,
        });
    });

    function changestatus(id) {

        $.post("<?php echo base_url() ?>administrator/userpage/changeactiveTosuspend", {id: id}, function (data) {

            if (data.success) {

                $('.result-msg').html('You have successfully change The Status');
                $(".result-msg").show().delay(5000).fadeOut();
                setTimeout(function () {
                    window.location = "<?php echo base_url(); ?>administrator/userpage/loadpage/webuser/subpage/suspendclient";
                }, 5000);
            }
            else {
                alert('Opps!! Something went wrong.');
            }

        }, 'json');

    }



</script>
<style>
    .dataTables_length {
        display: none;
    }
    .dataTables_info {
        float: left;
        margin-bottom: 25px;
    }
    .dataTables_paginate.paging_simple_numbers {
        float: right;
        position: relative;
        top: 0;
        width: auto;
    }
    #example_paginate a {
        padding: 5px;
    }
    .facd {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border-bottom: 1px solid #929292;
        border-right: 1px solid #929292;
        border-top: 1px solid #929292;
        display: block;
        float: none;
        overflow: hidden;
        padding: 0;
    }
    .fa.fa-check {
        background: #1da7da none repeat scroll 0 0;
        display: block;
        float: left;
        padding: 7px;
    }
</style>
