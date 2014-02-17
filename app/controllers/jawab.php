<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jawab extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('team');
		$this->load->model('answers','aw');
		$this->load->model('credential','ct');
		$this->load->model('score','sc');
		$this->load->model('lomba');
		$this->load->model('msoal','sa');
		
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('inflector');
	}
	
	function index() {
		$this->ct->auth('admin,juri',urlencode(current_url()));
		
		$teams	= $this->team->get_team();
		
		if (count($teams) == 0) {
			$data['warning'] = TRUE;
		} else {
			$data['warning'] = FALSE;
		}
		
		$this->templates->juragan('jawab/answer', $data);
	}
	
	function treeteam() {
		$this->ct->auth('admin,juri',urlencode(current_url()));
		$teams	= $this->team->get_team();				
		$tree	= array();
		
		foreach ($teams as $team) {
			$item['id']	= $team['id'];
			$item['text']	= $team['team_name'];
			$item['iconCls']	= 'icon-tip';
			$item['attributes']	= array(
				'url'	=> base_url() . 'jawab/load',
				'poinview'	=> base_url() . 'tim/score',
			);
				
			array_push($tree, $item);
		}
		
		echo json_encode($tree);
	}
	
	function load() {
		$this->ct->auth('admin,juri',urlencode(current_url()));
		
		$teamid			= $this->input->get('team'); // Input validation here
		$data['teamid']	= $teamid;
		
		$lomba			= $this->lomba->get_lomba();
		$data['lomba']	= $lomba;
		foreach ($lomba as $katagori) {
			$lom[$katagori->id]	= array();
		}
		
		$conv			= $this->aw->get_conversation($teamid);		
		
		
		foreach ($conv as $cakap) {
			
			//print_r($cakap['lomba_id']);echo "<br/><br/>";
			
			array_push($lom[$cakap['lomba_id']], $cakap);
			
		}		
		$data['lom']	= $lom;
		
		//print_r($lomba);
		
		
		
		
		//print_r($lom);
		$this->load->view('jawab/conversation',$data);
	}
	
	function save() {
		
		$this->ct->auth('admin,juri',urlencode(current_url()));
		
		$post['lomba_id']	= $this->input->post('lomba_id');
		$post['team_id']	= $this->input->post('team_id');
		$post['subject']	= $this->input->post('subject');
		$post['message']	= $this->input->post('message');
		$teamname			= $this->team->get_myteam($post['team_id']);
		$post['sender']		= 'admin';
		$post['timestamp']	= mdate("%Y-%m-%d %H:%i:%s");
		
		if ($_FILES['attach']['tmp_name'] == '') {
			
				
			if ($this->aw->set_answer($post)) {
				$this->templates->juragan('jawab/answer_sukses');
			} else {
				$this->templates->juragan('jawab/answer_gagal');
			}
		} else {
				
			$config['upload_path']		= '../uploads/';
			$config['allowed_types']	= 'doc|docx|pdf|odt';
			$config['max_size']			= '10000'; // 10MB
			$config['encrypt_name']		= TRUE;
				
			$this->load->library('upload', $config);
				
			if ( ! $this->upload->do_upload('attach'))
			{
				$data['error'] = array('error' => $this->upload->display_errors());
					
				$this->templates->juragan('jawab/answer_gagal',$data);
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
					
				
				$post['attachment']		= $data['upload_data']['full_path'];
				$post['client_name']	= $teamname->team_name . ' - ' .$data['upload_data']['client_name'];
				$post['raw_name']		= $data['upload_data']['raw_name'];
				
					
				if ($this->aw->set_answer($post)) {
					$this->templates->juragan('jawab/answer_sukses');
				} else {
					$this->templates->juragan('jawab/answer_gagal');
				}
			}
		}
	}
	
	function race() {
		$this->ct->auth('team',urlencode(current_url()));
		
		$lomba = $this->lomba->cek_time();

		if (count($lomba) > 0) {
			$soal = $this->sa->soal($lomba->id);
			
			$no = array();
	
			$data['lomba'] = humanize($lomba->nama);
			$data['lomba_id'] = $lomba->id;
			
			switch (strtolower($lomba->nama)) {
				case "cnd":
					foreach ($soal as $oal) {
						$no[$oal['soal']] = $oal['order'].'. '.$oal['soal'];
					}
					$data['no']	= $no;
					$this->templates->pusdatin('jawab/race_answer_cnd',$data);
				break;
				
				default:
					
					foreach ($soal as $oal) {
						$no[$oal['id']] = $oal['order'].'. '.$oal['soal'];
					}
					
					$answereds = $this->aw->get_answered($lomba->id,$this->session->userdata('userid'));
					
					foreach ($answereds as $answer) {
						unset($no[$answer->subject]);
					}
					
					$data['no']	= $no;
					$this->templates->pusdatin('jawab/race_answer',$data);
				break;
			}
		} else {
			$this->templates->pusdatin('jawab/race_off');
		}
	}
	
	function raceSaveCnd() {
		
		$this->ct->auth('team',urlencode(current_url()));
		$teamid		= $this->session->userdata('userid');
		$teamname	= $this->team->get_myteam($teamid);
		$lomba 		= $this->lomba->cek_time();
		if (count($lomba) > 0) {
			$config['upload_path']		= '../uploads/';
			$config['allowed_types']	= 'doc|docx|pdf|odt';
			$config['max_size']			= '10000'; // 10MB
			$config['encrypt_name']		= TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('attach'))
			{
				$data['error'] = array('error' => $this->upload->display_errors());
					
				$this->templates->pusdatin('jawab/answer_gagal',$data);
					
					
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				
				// print_r($data);
			
				
				
				$post['lomba_id']	= $this->input->post('lomba_id');		
				
				$post['team_id']		= $teamid; // Ambil dari session
				$post['subject']		= $this->input->post('subject');
				$post['message']		= $this->input->post('message');
				$post['attachment']		= $data['upload_data']['full_path'];
				$post['client_name']	= $teamname->team_name.' - '.$data['upload_data']['client_name'];
				$post['raw_name']		= $data['upload_data']['raw_name'];
				$post['sender']			= 'client';
				$post['timestamp']		= mdate("%Y-%m-%d %H:%i:%s");
					
				if ($this->aw->set_answer_cnd($post)) {
					$this->templates->pusdatin('jawab/answer_sukses');
				} else {
					$this->templates->pusdatin('jawab/answer_gagal');
				}
			}
		} else {
			$this->templates->pusdatin('jawab/race_off');
		}
	}
	
	function raceSave() {
	
		$this->ct->auth('team',urlencode(current_url()));
		$teamid		= $this->session->userdata('userid');
		$lomba 		= $this->lomba->cek_time();
		$teamname	= $this->team->get_myteam($teamid);
		
		if (count($lomba) > 0) { // kayaknya ifnya ga pas nih,,,
			if ($_FILES['attach']['tmp_name'] == '') {
				$post['lomba_id']	= $this->input->post('lomba_id');
				$post['team_id']	= $teamid;
				
				// id jawaban
				$post['subject']	= $this->input->post('subject');
				$post['message']	= $this->input->post('message');
			
				$post['sender']		= 'client';
				$post['timestamp']	= mdate("%Y-%m-%d %H:%i:%s");
				
				if ($this->aw->set_answer($post)) {
					$this->templates->pusdatin('jawab/answer_sukses');
				} else {
					$data['error'] = array('error'=> 'Jawaban anda tidak cocok');
					$this->templates->pusdatin('jawab/answer_gagal',$data);
				}
			} else {
		
				$config['upload_path']		= '../uploads/';
				$config['allowed_types']	= 'doc|docx|pdf|odt';
				$config['max_size']			= '10000'; // 10MB
				$config['encrypt_name']		= TRUE;
			
				$this->load->library('upload', $config);
			
				if ( ! $this->upload->do_upload('attach'))
				{
					$data['error'] = array('error' => $this->upload->display_errors());
			
					$this->templates->pusdatin('jawab/answer_gagal',$data);
			
			
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());									
						
					$post['lomba_id']	= $this->input->post('lomba_id');
					$post['team_id']		= $teamid; // Ambil dari session
					$post['subject']		= $this->input->post('subject');
					$post['message']		= $this->input->post('message');
					$post['attachment']		= $data['upload_data']['full_path'];
					$post['client_name']	= $teamname->team_name.' - '.$data['upload_data']['client_name'];
					$post['raw_name']		= $data['upload_data']['raw_name'];
					$post['sender']			= 'client';
					$post['timestamp']		= mdate("%Y-%m-%d %H:%i:%s");
			
					if ($this->aw->set_answer($post)) {
						$this->templates->pusdatin('jawab/answer_sukses');
					} else {
						$this->templates->pusdatin('jawab/answer_gagal');
					}
				}
			}
		} else {
			$this->templates->pusdatin('jawab/race_off');
		}
	}
	
	function raceConversation() {
		
		$this->ct->auth('team',urlencode(current_url()));
		
		$lomba = $this->lomba->cek_time();
		
		$teamid			= $this->session->userdata('userid');
		$data['conv']	= $this->aw->get_conversation($teamid,$lomba->id); //ambil dari session
		
		switch (strtolower($lomba->nama)) {
			case "cnd":
				$this->load->view('jawab/race_conversation_cnd',$data);
			break;
			
			default:
				$this->load->view('jawab/race_conversation',$data);
			break;
		}
		
	}
	
	function raceScoreSave() {
		$this->sc->save('score');
	}
	
	function raceScoreDelete() {
		$this->sc->delete('score');
	}
	
	function unduh($raw) {
		
		$download	= $this->aw->get_download($raw);		
		
		$this->load->helper('download');
		
		$data = file_get_contents($download->attachment); // Read the file's contents
		$name = $download->client_name;
		
		force_download($name, $data);
	}
	
	function unggah() {
		$this->ct->auth('team',urlencode(current_url()));
		
		$teamid		= $this->session->userdata('userid');
		
		$teamname	= $this->team->get_myteam($teamid);
		
		$config['upload_path']		= '../uploads/';
		$config['allowed_types']	= 'doc|docx|pdf|odt';
		$config['max_size']			= '10000'; // 10MB
		$config['encrypt_name']		= TRUE;
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('attach'))
		{
			$error = array('error' => $this->upload->display_errors());							
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
		
			
			$post['attachment']		= $data['upload_data']['full_path'];
			$post['client_name']	= $teamname->team_name.' - '.$data['upload_data']['client_name'];
			$post['raw_name']		= $data['upload_data']['raw_name'];
				/*
			if ($this->aw->set_answer($post)) {
				$this->templates->pusdatin('jawab/answer_sukses');
			} else {
				$this->templates->pusdatin('jawab/answer_gagal');
			}*/
			
			print_r($post);
		}
	}
}