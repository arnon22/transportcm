<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CIzACL
 * 
 * @copyright	Copyright (c) Schizzoweb Web Agency
 * @website		http://www.schizzoweb.com
 * @version		1.3
 * @revision	2013-06-14
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->lang->load('cizacl',$this->config->item('language'));
		if(!class_exists('CI_Cizacl'))
			show_error($this->lang->line('library_not_loaded'));
		$this->load->library('cizacl');
		$this->load->library('login');
		$this->load->model('login_mdl');
		$this->load->model('cizacl_mdl');
	}

	function index()
	{
		$this->load->view('cizacl/login');
        //var_dump($this->cizacl->check_hasRole('acount'));
        echo $this->session->userdata('user_id');
        echo $this->session->userdata('user_name');
        echo $this->session->userdata('user_surname');
        echo $this->session->userdata('user_lastaccess');
        echo $this->session->userdata('user_cizacl_role_id');
        echo site_url();
	}

	function check_login()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', $this->lang->line('username'), 'required');
		$this->form_validation->set_rules('password', $this->lang->line('password'), 'required');
		
		if ($this->form_validation->run() == false)	{
			die($this->cizacl->json_msg('error',$this->lang->line('attention'),validation_errors("<p><span class=\"ui-icon ui-icon-alert\" style=\"float: left; margin-right: .3em;\"></span>","</p>"),true));
		}
		else	{
			$this->load->model('login_mdl');
			$check_user_login = $this->login_mdl->check_user_login($this->input->post('username',true),$this->input->post('password',true));
			
			if($check_user_login)	{
				if($this->login_mdl->check_user_disabled($this->input->post('username',true),$this->input->post('password',true)))
					die($this->cizacl->json_msg('error',$this->lang->line('attention'),$this->lang->line('user_disabled'),true));
				elseif($this->login_mdl->check_user_block($this->input->post('username',true),$this->input->post('password',true)))	{
					die($this->cizacl->json_msg('error',$this->lang->line('attention'),$this->lang->line('user_block'),true));
				}
				else	{
					$this->db->from('users');
					$this->db->from('user_profiles');
					$this->db->from('cizacl_roles');
					$this->db->where('user_username',$this->input->post('username',true));
					$this->db->where('user_password',md5($this->input->post('password',true)));
					$this->db->where('user_id = user_profile_user_id');
					$this->db->where('user_cizacl_role_id = cizacl_role_id');
					$query = $this->db->get();
					$row = $query->row();
			
					// In caso di primo accesso
					$user_lastaccess = !empty($row->user_profile_lastaccess) ? $this->cizacl_mdl->mktime_format($row->user_profile_lastaccess) : '-';
			
					$session = array(
						'user_id'				=> $row->user_id,
						'user_name'				=> $row->user_profile_name,
						'user_surname'			=> $row->user_profile_surname,
						'user_lastaccess'		=> $user_lastaccess,
						'user_cizacl_role_id'	=> $row->user_cizacl_role_id
					);
					
					$this->db->update('user_profiles', array('user_profile_lastaccess ' => mktime()), 'user_profile_user_id = '.$row->user_id);
					
					$this->session->set_userdata($session);
					
					die($this->cizacl->json_msg('success',$this->lang->line('wait'),$this->lang->line('login_progress'),false,site_url($row->cizacl_role_redirect)));
				}
			}
			else
				die($this->cizacl->json_msg('error',$this->lang->line('attention'),$this->lang->line('user_not_found')));

		}
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect();
	}
	
}
