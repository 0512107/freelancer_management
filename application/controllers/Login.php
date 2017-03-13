<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Login extends CI_Controller{
	protected $_salt = '5&JDDlwz%Rwh!t2Yg-Igae@QxPzFTSId';
    public function __construct() {
        parent::__construct();
    }
     
    public function index() {
		if ($this->session->userdata('is_user_login')) {
            $arr['page']='dash';
			$this->load->view('viewDashboard',$arr);
        } else {
			$this->load->view('viewLogin');
        }
    }
	
	public function do_login() {
		if ($this->session->userdata('is_user_login')) {
            redirect('dashboard');
        } else {
			if ($this->input->method() == "post") {
				$this->load->model('user');
				$email = trim($this->input->post('email'));
				$password = trim($this->input->post('pass'));
                $enc_pass  = md5($this->_salt . $password);
                $val = $this->user->getList("*", array('email' => $email, 'password' => $enc_pass));
				if (count($val) > 0) {
                    foreach ($val as $recs => $res) {
                        $this->session->set_userdata(
							array(
								'id' => $res['id'],
								'email' => $res['email'],     
								'full_name' => $res['full_name'],
								'role' => $res['role'],
								'is_user_login' => true
							)
                        );
                    }
					echo json_encode(array("result" => "success", "message" => "<strong>Access Denied</strong> Invalid Email/Password"));
                    exit;
                } else {
					echo json_encode(array("result" => "error", "message" => "<strong>Access Denied</strong> Invalid Email/Password"));
					exit;
                }
			} else {
				$this->load->view('viewLogin');
			}
		}
		
	}
	
	public function logout() {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('email');
		$this->session->unset_userdata('full_name');
        $this->session->unset_userdata('is_user_login');   
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('/', 'refresh');
    }
	
	public function forgot_password() {
		$email = $this->input->post('email');
		$this->load->model('user');
		$alreadyUser = $this->user->getCount(array('email' => $email));
		if ($alreadyUser > 0) {
			$code = $this->generateCode();
			$data = array(	  
				'forgot_password' => $code,
			);
			
			if ($this->user->update($data, array('email' => $email))) {
				if ($this->sendEmailForgotPassword($code, $email, $data)) {
					echo json_encode(array("result" => "success", "message" => "An email has been sent to the address provided."));
					exit;
				} else {
					echo json_encode(array("result" => "error", "message" => "Email can not send"));
					exit;
				}
			} else {
				echo json_encode(array("result" => "error", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			}
		} else {
			echo json_encode(array("result" => "error", "message" => "Error: E-mail address does not exist in our record"));
			exit;
		}
		
	}
	
	public function new_password ($code = "") {
		$arr['code'] = $code;
		if ($this->input->method() == "post") {
			if (empty($code)) {
				echo json_encode(array("result" => "error", "message" => "<strong>Error:</strong> Whoops! There was an error "));
				exit;
			} else {
				$this->load->model('user');
				$password = $this->security->xss_clean($this->input->post('password'));
				$enc_pass  = md5($this->_salt . $password);
				
				$user = $this->user->getList("*", array('forgot_password' => $code));
				if (count($user) > 0) {
					$data = array(	  
						'forgot_password' => '',
						'password' => $enc_pass
					);
					if ($this->user->update($data, array('forgot_password' => $code))) {
						echo json_encode(array("result" => "success", "message" => "<strong>Success:</strong> New Password has been updated"));
						exit;
					}
				} else {
					echo json_encode(array("result" => "error", "message" => "<strong>Error:</strong> Whoops! There was an error "));
					exit;
				}
			}
		}
		$this->load->view('viewNewPassword', $arr);
	}
	
	private function generateCode() {
		$this->load->model('user');
		$validCode = false;
		$code = "";
		while(!$validCode){
			$code = mt_rand();
			
			$numRow = $this->user->getCount(array('forgot_password' => $code));
			if($numRow == 0 ) {
				$validCode = true;
			}
		}
		return $code;
	}
	
	private function sendEmailForgotPassword($code, $email, $data) {
		$url = base_url() . "login/new_password/" . $code;
		$body = '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td style="padding: 15px; padding-top: 20px;"><p>Hi dear,</p><p>We received a request to reset your password. Follow the link below to set up a new password:</p><p><a href="' . $url . '">' . $url . "</a></td></tr></table>";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: no-reply@domain.com' . "\r\n";
		if (mail($email, 'Password reset', $body, $headers)) {			
			$data['submit_success'] = true;
			$this->load->view('viewLogin', $data);
			return true;
		} else {
			return false;
		}
	}
}
?>