<?php

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

class Login_Mdl extends CI_Model	{
	function __construct()
	{
		parent::__construct();
	}
	
	function check_user_login($user,$pwd)
	{
		$this->db->where('user_username',$user);
		$this->db->where('user_password',md5($pwd));
		$query = $this->db->get('users');
		if($query->num_rows)
			return true;
	}

	function check_user_disabled($user,$pwd)
	{
		$this->db->from('users');
		$this->db->from('user_profiles');
		$this->db->where('user_username',$user);
		$this->db->where('user_password',md5($pwd));
		$this->db->where('user_id = user_profile_user_id');
		$query = $this->db->get();
		$row = $query->row();
		if($row->user_profile_user_status_code == 2)
			return true;
	}
	
	function check_user_block($user,$pwd)
	{
		$this->db->from('users');
		$this->db->from('user_profiles');
		$this->db->where('user_username',$user);
		$this->db->where('user_password',md5($pwd));
		$this->db->where('user_id = user_profile_user_id');
		$query = $this->db->get();
		$row = $query->row();
		if($row->user_profile_user_status_code == 3)
			return true;
	}

	function check_username($username)
	{
		$this->db->where('LOWER(user_username)',strtolower($username));
		$query = $this->db->get('users');
		if($query->num_rows())
			return true;
		else
			return false;
	}
	
}