<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Form_Validation Class
 *
 * Extends Validation library
 *
 * Adds one validation rule, valid_url to check if a field contains valid url
 */
 
class MY_Form_Validation extends CI_Form_validation {

    // --------------------------------------------------------------------

    /**
     * valid_url
     *
     * @access	public
     * @param	field
     * @return	bool
     */
    function valid_url($field)
    {
        $CI =& get_instance();
        
        $CI->form_validation->set_message('valid_url', 'The %s field must contain a valid url.');

        return ( ! preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $field)) ? FALSE : TRUE;
    }
	
    /**
     * valid_option
     *
     * @access	public
     * @param	field
     * @return	bool
     */
    function valid_option($field)
    {
        $CI =& get_instance();
        
        $CI->form_validation->set_message('valid_option', 'A valid option in the %s field must be selected.');
		
		if(empty($field))
			return FALSE;
		else
			return TRUE;
    }

    /**
     * valid_username
     *
     * @access	public
     * @param	field
     * @return	bool
     */
    function valid_username($field)
    {
        $CI =& get_instance();

		$CI->load->model('login_mdl');
        
        $CI->form_validation->set_message('valid_username', 'Another user exists with the some username.');
		
		if($CI->login_mdl->check_username($field))
			return FALSE;
		else
			return TRUE;
    }
}