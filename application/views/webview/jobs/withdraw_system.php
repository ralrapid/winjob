<style type="text/css">
#buttonfirst {
    background: #eba705 none repeat scroll 0 0;
    border: medium none;
    border-radius: 5px;
    color: #fff;
    float: left;
    font-family: "Arial";
    font-size: 17.5px;
    margin-top: 2px;
    padding: 5px 7px;
}
</style>

<?php

function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array(365 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    $a_plural = array('year' => 'years',
        'month' => 'months',
        'day' => 'days',
        'hour' => 'hours',
        'minute' => 'minutes',
        'second' => 'seconds'
    );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}
?>



<section id="big_header" style="margin-top: 40px; margin-bottom: 40px; height: auto; overflow: hidden; margin-left: 4px;border-radius: 4px;width: 1000px;">
    <div class="">
        <div class="row">
            <div style="border: 1px solid #ccc;border-radius: 4px 4px 0 0;background: #fff;padding: 20px 30px;margin-left: 15px;width: 750px;margin-bottom: 0;border-bottom: 0;" class="col-md-9 col-md-offset-0 page-title">                
                <div class="row">					
                    <div class="col-md-10 page-label">
                        <h1 class="job-title cos_job-title"><?php echo ucfirst($value->title) ?></h1>
                    </div>
					
					<div class="col-md-2 page-label">                        
                        <span style="margin-top: -15px;" class="pull-right"><?php
                             $timeDate = strtotime($value->created);
                            $dateInLocal = date("Y-m-d H:i:s", $timeDate);
                            echo time_elapsed_string(strtotime($dateInLocal)); ?></span>
                    </div>
                </div>
				
			<div class="jobdes-bordered-wrapper">
                <div class="row jobdes-bordered page-label">
                    <div class="col-md-3 text-center">
                        <label style="font-family: calibri;font-size: 17px;">Job Type</label> <br /> <span><?php echo ucfirst($value->job_type) ?></span>
                    </div>

                    <div class="col-md-3 text-center page-label">
                        <label style="font-family: calibri;font-size: 17px;">
                            <?php
                            if ($value->job_type == 'hourly')
                            {
                                echo "Hourly Per week";
                            } else
                            {
                                echo 'Budget $';
                            }
                            ?>
                        </label><br /><span><?php
                            if ($value->job_type == 'hourly')
                            {
                                echo $value->hours_per_week;
                            } else
                            {
                                echo '$' . round($value->budget, 2);
                            }
                            ?></span>
                    </div>

                    <div class="col-md-3 text-center page-label">
                        <label style="font-family: calibri;font-size: 17px;">Job Duration</label><br /> <span><?php echo str_replace('_', '-', $value->job_duration) ?></span>
                    </div>

                    <div class="col-md-3 last-div text-center page-label">
                        <label style="font-family: calibri;font-size: 17px;">Experience Level</label><br /> <span><?php echo ucfirst($value->experience_level); ?></span>
                    </div>
                </div>
</div>

                <div class="row margin-top page-label">
                    <div class="col-md-2">
                        <label style="font-family: calibri;font-size: 16px;">Job Category</label>
                    </div>
                    <div style="margin-top: 4px;" class="col-md-10">
                       <?php 
                       
                       $this->db->select('*');
				$this->db->from('job_subcategories'); 
				$this->db->where('subcat_id',$value->category);
				$query_done = $this->db->get();
                                $result= $query_done->row();
                                echo $result->subcategory_name;
                       ?>
                    </div>
                </div>
					
				<div class="row margin-top page-label">
                    <div class="col-md-2">
                        <label>Skills</label>
                    </div>

                    <div class="col-md-10 skills page-label">
                    <div class="custom_user_skills">
                        <?php
                        if (isset($value->skills) && !empty($value->skills))
                        {
                            $skills = explode(' ', $value->skills);
                            foreach ($skills as $skill)
                                echo "<span> $skill</span> ";
                        }
                        ?>
                    </div>
                    </div>
                </div>

                <div class="row margin-top page-label">
                    <div class="col-md-9">
                        <label>Detail</label>
                    </div>
                    <div style="font-family: calibri; font-size: 16px; margin-bottom: 17px; margin-top: 8px;" class="col-md-12 text-justify page-label"><?php echo ucfirst($value->job_description) ?></div>

                </div>
<div class="jobdes-bordered-wrapper">
                <div class="row jobdes-bordered page-label">
                    <div class="col-md-4 text-center">
 <?php 
 $this->db->select('*');
$this->db->from('job_bids');
$this->db->where(array('job_id'=>$value->job_id,'bid_reject'=>0, 'status!=1'=>null));
$query =$this->db->get();
$Proposals_count = $query->num_rows();
$jobfeedback= $query->result();
?>
                        <label style="font-family: calibri;font-size: 17px;">Proposals</label> <br /> <span><?=$Proposals_count;?></span>
                    </div>

                    <div class="col-md-4 text-center page-label">
 <?php 
$this->db->select('*');
$this->db->from('job_conversation');
$this->db->where('job_conversation.sender_id', $value->clientid);
$this->db->join('job_bids', 'job_bids.id=job_conversation.bid_id', 'inner');
$this->db->where('job_conversation.job_id', $value->job_id);
$this->db->where('job_bids.bid_reject', 0);
$this->db->group_by('bid_id'); 
$query=$this->db->get();
$interview_count = $query->num_rows();
?>
                        <label style="font-family: calibri;font-size: 17px;">Interviewing</label><br /> <span><?=$interview_count;?></span>
                    </div>

                    <div class="col-md-4 last-div text-center page-label">
<?php
$this->db->select('*');
$this->db->from('job_accepted');
$this->db->join('job_bids', 'job_bids.id=job_accepted.bid_id', 'inner');
$this->db->where('job_accepted.buser_id',$value->clientid);
$this->db->where('job_accepted.job_id',$value->job_id);
$this->db->where('job_bids.hired', '0' );
$this->db->where('job_bids.jobstatus', '0' );
$query=$this->db->get();
$hire_count = $query->num_rows();
?>
                        <label style="font-family: calibri;font-size: 17px;">Hired</label><br /> <span>
                            <?php echo $hire_count;?>
                        </span>
                    </div>

                </div>
                </div>
            </div>
			
            <div style="margin-left: -2px;margin-top: 20px;" class="col-md-3" >
                <div class="row client-activity">
                    <div style="padding: 0 30px 9px;border-radius: 4px;width: 210px;" class="col-md-10 col-md-offset-2 right-section ">
                        <div class="row margin-top-2">
                            <div class="col-md-12">
                                
                                <?php
if ($value->isactive && $paymentSet) {
    ?>
										<i style="margin-top: -10px; margin-left: -4px; font-size: 25px; color: rgb(2, 143, 204);position: absolute;top: 8px;" class="fa fa-check-circle"></i>
                                        <?php
                                    } else {
                                        ?>
                                        <i style="margin-top: -10px; margin-left: -4px; font-size: 25px; color: rgb(187, 187, 187);position: absolute;top: 8px;" class="fa fa-minus-circle"></i>
                                        <?php
                                    }
                                    ?>
                                <label style="margin-left: 25px;"><?php echo ucfirst($value->webuser_fname) ?></label>
                                
                                
                            </div>
                        </div>
                        <div style="margin-top: 10px;margin-left: -19px;" class="row margin-top-2 border-bottom">
                            <div class="col-md-8 ">
								<?php if($total_feedbackScore !=0 && $total_budget!=0){
                                $totalscore = ($total_feedbackScore / $total_budget);
                                $rating_feedback = ($totalscore/5)*100;
                               ?>
                                <button style="font-size: 10px;background:#F77D0E;padding: 2px 4px;border-radius: 2px;" id="buttonfirst"><?=number_format((float)$totalscore,1,'.','');?></button>
								<div title="Rated <?=$totalscore;?> out of 5" class="star-rating" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating" style="right: -8%;margin-top: -3%;position: absolute;">
								<span style="width:<?=$rating_feedback;?>%">
									<strong itemprop="ratingValue"><?=$totalscore;?></strong> out of 5
								</span>
								</div>
							<?php  }else{ ?>
                             <button style="font-size: 10px;background:#F77D0E;padding: 2px 4px;border-radius: 2px;"  id="buttonfirst">0.0</button>
								<div style="right: -8%;margin-top: -3%;position: absolute;" title="Rated 0 out of 5" class="star-rating" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating" style="right: -45%;margin-top: 2%;position: absolute;">
								<span style="width:0%">
									<strong itemprop="ratingValue">0</strong> out of 5
								</span>
								</div>
                          <?php   } ?>
                               
                            </div>
                        </div>
                        <div style="margin-top: 14px;margin-left: -19px;" class="row margin-top-2 border-bottom">
                            <div class="col-md-12">
                                <label style="font-family: Calibri;font-size: 20.26px;color: #494949;margin-top: -29px;">
                                   <?php if(!empty($record_sidebar)){
                                        echo count($record_sidebar);
                                    }else{
                                        echo "0";
                                    } ?>
								<span style="font-size: 14px;color: #494949;font-family: calibri;">Jobs Posted</span>
								</label>
                            </div>
                        </div>
                        <div style="margin-top: 4px;margin-left: -19px;" class="row margin-top-2 border-bottom">
                            <div class="col-md-12">
                                <label style="font-family: Calibri;font-size: 20.26px;color: #494949;margin-top: -29px;">
								<?=count($hire);?> 
								<span style="font-size: 14px;color: #494949;font-family: calibri;">Hired</span>
								</label>
                            </div>
                        </div>
                        <div style="margin-top: 2px;margin-left: -19px;" class="row margin-top-2 border-bottom">
                            <div class="col-md-12">
                                <label style="font-family: Calibri;font-size: 20.26px;color: #494949;margin-top: -29px;">
								<?php $total_work = 0;
                                    if(!empty($workedhours)){
                                        foreach($workedhours as $work){
                                            $total_work +=$work->total_hour;
                                        }
                                        echo $total_work." <span style='font-size: 14px;color: #494949;font-family: calibri;'>Hours</span>";
                                    }else{
                                        echo " 0 <span style='font-size: 14px;color: #494949;font-family: calibri;'>Hours Worked</span>";
                                    }?>
								</label>
                            </div>
                        </div>

                        <div style="margin-top: 4px;margin-left: -19px;" class="row margin-top-2 border-bottom">
                            <div class="col-md-12">
                                <label style="font-family: Calibri;font-size: 20.26px;color: #494949;margin-top: -29px;">
								$<?php echo round($total_spent,0);?>
								<span style="font-size: 14px;color: #494949;font-family: calibri;">Spent</span>
								</label>
                            </div>
                        </div>
                        <div class="row margin-top-2 border-bottom">
                            <div style="font-family: Calibri;font-size: 18px;margin-left: 12px;margin-top: -15px;margin-bottom: 5px;">
								
								<i class="fa fa-map-marker"></i>
								
								<label style="font-family: Calibri;font-size: 20.26px;color: #494949;margin-top: -29px;">
								<span style="font-size: 14px;color: #494949;font-family: calibri;"><?php
                                $this->db->where('country_id', $value->webuser_country);
                                $q = $this->db->get('country');
                                $record = $q->row();
                                echo ucfirst($record->country_name);
                                ?></span>
								</label>
                            </div>
                        </div>

                    </div>
                </div>

            </div>


        </div>

    </div>

    <div class="container">
        <div style="background: #fff;width: 750px;border: 1px solid #ccc;border-top: 0;border-radius: 0 0 4px 4px;" class="row">
            <div class="col-md-9" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; padding-left: 45px;">
                <div class='form-msg'></div>            
                <div class="row">
                    <div style="border: 1px solid rgb(204, 204, 204); width: 698px;border-radius: 4px;margin-top: 20px;" class="col-md-12">
                        <div class="row">
								<?php
							   // print_r($value);
								
								if($value->status=='1'){?>
									<div class="alert custom-alert-warning">
										<strong>Warning!</strong> You have withdraw with this job.
									</div>
									<?php }else{
										// added by jahid start 
									 /*
									?>
								 <div class="alert alert-warning">
										<strong>Warning!</strong> The job does not exist.
									</div>
								<?php 
									*/
										// added by jahid end 
									}
								?>
                            <div style="text-align: center;" class="col-md-7 col-centered custom_sp">
								
								<div class="row">
                                    <div class="col-md-12">
                                        <label style="margin-bottom: -3px;">Submitted Proposal</label>
                                    </div>
                                </div>

                                <div class="row margin-top-2">
                                    <div class="col-md-12">
                                        <label>Your proposed terms</label>
                                    </div>
                                </div>

                                <div class="row margin-top-2">
                                    <div class="col-md-12">
                                        <label>Rate : </label>
									
									<?php
                                    $perHrs = '';
                                    if ($value->job_type == 'hourly')
                                    {
                                        $perHrs = '/hr';
                                    }
                                    ?>
                                        <label>$<amt id='bid_earning_read'><?php echo round($value->bid_earning, 2); ?></amt><?php echo $perHrs ?></label> ($<amt id='bid_amount_read'><?php echo round($value->bid_amount, 2); ?></amt><?php echo $perHrs ?> charge to client)
                                    </div>

                                </div>
 <?php //if($value->status!='1')
 {?>
                                <div class="row margin-top-2">
                                    <div class="col-md-12">
                                        <input style="margin-left: 15px;" type="button" class="btn btn-primary form-btn" value="Propose Different Terms" data-toggle="modal" data-target="#myModal2"/>
                                    </div>
                                </div>

                                <div class="row margin-top-2">
                                    <div class="col-md-12 text-center">
                                        <a href="#" data-toggle="modal" data-target="#myModal">Withdraw Proposal</a>
                                    </div>
                                </div>
 <?php }?>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-11">
                        <div class="row">
                            <div style="margin-top: 30px;" class="col-md-11 margin-left-2 margin-top-2">
                                <p class="custom_cover-letter">Cover Letter</p>
                            </div>
                        </div>

                        <div class="row margin-top-2">
                            <div class="col-md-11 margin-left-2">
                                <p style="margin-bottom: 32px;" style="margin-bottom: 10px; color: rgb(73, 73, 73);" class="custom_cover-letter-text"><?php echo ucfirst($value->cover_latter) ?></p>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div style="border-bottom: 50px;padding-left:30px;padding-right:30px;padding-top: 50px;text-align: center;" class="modal-content">
                            <div class="modal-header" style="border-bottom: 0;padding-top: 20px;border-radius: 4px 4px 0 0;">
                                <button style="position: absolute;top: 35px;right: 29px;font-size: 30px;" type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                <h4 style="margin-top: 0px;" class="modal-title">Withdraw Proposal</h4>
                            </div>
                            <div style="border-radius: 0 0 4px 4px;margin-bottom: 50px;" class="modal-body">
                                <p style="margin-left: 15px;font-size: 17px;font-family: calibri;margin-bottom: 20px;">Are you sure you want to withdraw this proposal?</p>
                            <div class="modal-footer" style="text-align: left; border-top: none">
                                <form method="post" id='jobWithDraw'>
                                    <input type="hidden" name='bid_id' value='<?php echo $value->id; ?>'/>
                                    <input type="hidden" name='withdraw' value='1'/>
                                    <input style="float: left;margin-left: 200px;" type="submit" class="btn-primary big_mass_active transparent-btn big_mass_button form-btn" value="Withdraw Proposal" />
                                    <input style="float: left;" type="button" class="btn-primary transparent-btn big_mass_button" value="Cancel" data-dismiss="modal" />
                                    <img src='/assets/img/version1/loader.gif' class="form-loader" style="display:none">
                                </form>
                            </div>
                            </div>
                        </div>

                    </div>
                </div>






                <div id="myModal2" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div style="padding-top: 50px;padding-bottom: 50px;padding-left: 30px;padding-right: 30px;" class="modal-content">
                            <div class="modal-header" style="border-bottom: 0;padding-top: 20px;border-radius: 4px 4px 0px 0px;">
                                <button style="position: absolute;top: 35px;right: 29px;font-size: 30px;" type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                <h4 class="modal-title">Proposed Terms</h4>
                            </div>
                            <div style="border-radius: 0 0 4px 4px;" class="modal-body">
                                <form method="post" id='jobApply'>
                                    <input type="hidden" name='bid_id' value='<?php echo $value->id; ?>'/>
                                    <input type="hidden" name='proposal' value='1'/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="margin-bottom: 20px;margin-top: 15px;" class="row">
                                                <div class="col-md-3 col-md-offset-3 page-label">
                                                    <label>Your Bid</label>
                                                </div>

                                                <div style="margin-left: -60px;" class="col-md-6">
                                                    <div class="col-md-1">$</div>
                                                    <div class="col-md-5">
                                                        <input style="font-size: 16px;font-family: calibri;float: left;width: 80px;margin-left: -9px;margin-top: -10px;margin-right: 5px;" type="text" class="form-control" name='bid_amount' id='bid_amount' value='<?php echo round($value->bid_amount, 2); ?>' style="float: left;width: 75px"/><label style=' margin-left: 2px;margin-top: 6px;position: absolute;'><?php echo $perHrs ?></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div style="margin-bottom: 20px;" class="row">
                                                <div class="col-md-3 col-md-offset-3 page-label">
                                                    <label>10% Winjob Fee</label>
                                                </div>

                                                <div style="margin-left: -60px;" class="col-md-6">
                                                    <div class="col-md-1">$</div>
                                                    <div class="col-md-5">
                                                        <input style="font-size: 16px;font-family: calibri;float: left;width: 80px;margin-left: -9px;margin-top: -10px;margin-right: 5px;" type="text" class="form-control" name='bid_fee' id='bid_fee' disabled style="float: left;width: 75px" /><label style=' margin-left: 2px;margin-top: 6px;position: absolute;'><?php echo $perHrs ?></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div style="margin-bottom: 20px;" class="row">
                                                <div class="col-md-3 col-md-offset-3 page-label">
                                                    <label>Your Earnings</label>
                                                </div>

                                                <div style="margin-left: -60px;" class="col-md-6">
                                                    <div class="col-md-1">$</div>
                                                    <div class="col-md-5">
                                                        <input style="font-size: 16px;font-family: calibri;float: left;width: 80px;margin-left: -9px;margin-top: -10px;margin-right: 5px;" type="text" class="form-control" name='bid_earning' id='bid_earning' disabled style="float: left;width: 75px"/><label style=' margin-left: 2px;margin-top: 6px;position: absolute;'><?php echo $perHrs ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer" style="text-align: center; border-top: none">
                                        <input style="float: left;margin-left: 320px" type="submit" class="btn-primary big_mass_active transparent-btn big_mass_button" value="Done" />
                                        <input style="float: left;" type="button" class="btn-primary transparent-btn big_mass_button" value="Cancel" data-dismiss="modal" />
                                        <img src='/assets/img/version1/loader.gif' class="form-loader" style="display:none">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-md-3"></div>
            </div>

        </div>

</section>