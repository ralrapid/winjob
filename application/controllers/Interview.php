<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Interview extends CI_Controller{

    public function __construct()

    {

        parent::__construct();

        $this->load->model(array('common_mod','Category'));

    }

    public function index()

    {

        if ($this->Adminlogincheck->checkx()) {

			

			if(isset($_GET['user_id'])){

				$user_id = base64_decode($_GET['user_id']);

			} else {

				$user_id = $this->session->userdata(USER_ID);

			}

			

			if(isset($_GET['job_id'])){

				$job_id = base64_decode($_GET['job_id']);

			}

			if(isset($_GET['bid_id'])){

				$bid_id = base64_decode($_GET['bid_id']);

			}

			//print_r($job_id); die;
			
			/* added by Jahid start */
        	$this->db->select('*');
            $this->db->from('job_bids');
            $this->db->where('job_bids.id', $bid_id);
            $this->db->where('job_bids.user_id', $user_id);
            $this->db->where('job_bids.job_id', $job_id);
            $query = $this->db->get();
            $result = $query->result();
            // echo $this->db->last_query(); exit;
            $params['conversation_msg_count'] = $result;
           /*
            $sender_id = $this->session->userdata(USER_ID);
            $this->db->select('*');
            $this->db->from('job_conversation');
            $this->db->join('job_bids', 'job_conversation.bid_id=job_bids.id', 'inner');
            $this->db->where('job_conversation.sender_id', $sender_id);
            $this->db->where('job_conversation.job_id', $job_id);
            $this->db->where('job_bids.bid_reject', 0);
     
            $this->db->where('job_conversation.receiver_id', $user_id);
            $this->db->where('job_bids.id', $bid_id);
            $this->db->where('job_bids.job_progres_status', 1);
            $this->db->where(array('job_bids.withdrawn' => NULL));

          
           
            $query = $this->db->get();
            $conversation_msg_count = $query->num_rows();          
            $params['conversation_msg_count'] = $conversation_msg_count;
            */
           // echo  $conversation_msg_count; exit;
         //  echo $this->db->last_query(); exit;
            /* added by Jahid end */

				

			$this->db->select('job_conversation.*,webuser.*,jobs.title');

			$this->db->from('job_conversation');

			$this->db->join('webuser', 'job_conversation.sender_id = webuser.webuser_id', 'inner');

			$this->db->join('jobs', 'jobs.id = job_conversation.job_id', 'inner');

			$this->db->where('job_conversation.job_id', $job_id);

			$this->db->where('job_conversation.bid_id', $bid_id);			

			//$this->db->where('job_conversation.have_seen', 1);

			//$this->db->order_by("job_conversation.id", "desc");

			//$this->db->group_by('bid_id'); 

			$query=$this->db->get();

			$conversation_count = $query->num_rows();

			$result = $query->result();

			$params['messages'] = $result;

			//print_r($result); die;

			

			$job_info = array();

			if(isset($_GET['job_id'])){

				$job_id = base64_decode($_GET['job_id']);

			//get job info//

			$this->db->select('job_bids.*,jobs.job_type,jobs.title');

			$this->db->from('job_bids');

			$this->db->join('jobs', 'jobs.id = job_bids.job_id', 'inner');

			$this->db->where('job_bids.user_id', $user_id);

			$this->db->where('job_bids.job_id', $job_id); 

			$query=$this->db->get();

			$conversation_count = $query->num_rows();

			$job_info = $query->result();

            //get webuser info//

			} 

            $cols = array("webuser_id","webuser_fname","webuser_lname","webuser_picture","webuser_country");

            $condition = " AND webuser_id=". $user_id ;

            $data = $this->common_mod->getColsVal(WEB_USER_TABLE,$cols,$condition);

			

			$this->db->select('*');

			$this->db->from('webuser');

            $this->db->where('webuser.webuser_id', $this->session->userdata(USER_ID));

            $query_status = $this->db->get();

			$ststus = $query_status->row();

			

			

			

			

            if(!empty($data['rows'][0])){

                //get country//

                $sql = " AND country_id = ".$data['rows'][0]['webuser_country']." ";

                $data['rows'][0]['webuser_country_name'] = $this->common_mod->getSpecificColVal(COUNTEY_TABLE,"country_name",$sql);

                $params['webUserInfo'] = $data['rows'][0];



                //get basic information//

                $data2 = $this->common_mod->get(WEB_USER_BASIC_PROFILE_TABLE,null,$condition);

                if(!empty($data2['rows'][0])){

                    $title = "";

                    if(strlen($data['rows'][0]["webuser_fname"]) > 0){

                        $title = $data['rows'][0]["webuser_fname"];

                    }

                    if(strlen($data2['rows'][0]["tagline"]) > 0){

                        $title .= " | ".$data2['rows'][0]["tagline"];

                    }

                    $params['title'] = $title;

                    $params['basicDetails'] = $data2['rows'][0];

					$params['job_info'] = $job_info;

					$params['ststus'] = $ststus;

					$this->Admintheme->webview2("interview",$params);

                }else{

                    redirect(site_url("profile/basic"));

                }

            }

        }else{

            redirect(site_url("signin"));

        }

    }

	

	public function insert_message(){

		

		//parse_str($_POST['form'], $form);

		

		$sender_id = $this->session->userdata(USER_ID);

		$freelancer_id = $this->input->post('freelancer_id');

		$job_id = $this->input->post('job_id');

		$bid_id = $this->input->post('bid_id');

		$messsage = $this->input->post('messsage');

		

		if($bid_id == 0){

			

			$this->db->select('*');

			$this->db->from('job_bids');

			$this->db->where('job_bids.user_id', $freelancer_id);

			$this->db->where('job_bids.job_id', $job_id); 

			$query=$this->db->get();

			$job_bid_details = $query->result();

			$bid_id = $job_bid_details[0]->id;

		}

		



		$data = "INSERT INTO job_conversation set job_id = '".$job_id."', bid_id = '".$bid_id."',  message_conversation = '".$messsage."', sender_id = '".$sender_id."', receiver_id = '".$freelancer_id."', have_seen = 1 ";

		$this->db->query($data);

		$insert_id = $this->db->insert_id();

		// added by jahid start 
                
               $data_up = "UPDATE job_bids SET job_progres_status=1  WHERE id=$bid_id;";
	       $this->db->query($data_up);
                
                // added by jahid end 

		

		

		$this->db->select('job_conversation.*,webuser.*,jobs.title,wu.webuser_fname as fname,wu.webuser_lname as lname,wu.webuser_id as r_id');

		$this->db->from('job_conversation');

		$this->db->join('webuser', 'job_conversation.sender_id = webuser.webuser_id', 'inner');

		$this->db->join('jobs', 'jobs.id = job_conversation.job_id', 'inner');

		$this->db->join('webuser as wu', 'jobs.user_id = wu.webuser_id', 'inner');

		$this->db->where('job_conversation.bid_id', $bid_id);

		$this->db->order_by("job_conversation.id", "desc"); 

		$query=$this->db->get();

		$conversation_count = $query->num_rows();

		$result = $query->result();

		

		

		$html = '';

		if(($result[0]->webuser_picture) == "") { 

				$src = site_url("assets/user.png");

			 } else { 

				$src = base_url().$result[0]->webuser_picture;

			 } 

			$html .='<li style="padding:20px">';

			$html .='<span class="name"><img src="'.$src.'"> '.$result[0]->webuser_fname.' '.$result[0]->webuser_lname.' </span>';

			$html .='<span class="chat-date">'.date("g:i a", strtotime($result[0]->created)).'</span>';

			$html .='<span class="details">'.$result[0]->message_conversation.'</span>';

			$html .='</li>';



		print_r(json_encode($html)); die;

		

	}

	

	

	

}



?>