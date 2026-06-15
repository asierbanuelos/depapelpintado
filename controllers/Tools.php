<?php

class Tools extends CI_Controller {

        public function message($to = 'World')
        {
                echo "Hello {$to}!".PHP_EOL;
        }

	public function output_delete_cache($uri)
	{
		if($uri) 
		{
			$this->output->delete_cache($uri);
		}		
	}

	public function db_cache_delete() 
	{
		$this->load->database();
		$this->db->cache_delete_all();
	}

}
?>
