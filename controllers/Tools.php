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

		// Limpiar tambien la cache custom de listados/portada (cache_delete_all NO la borra).
		// Son ficheros sueltos en application/cache/: items_*, filtros_*, countitems_*
		// (incluye .cache y .cache.lock).
		$borrados = 0;
		foreach (array('items_*', 'filtros_*', 'countitems_*') as $patron) {
			foreach (glob(APPPATH.'cache/'.$patron) as $fichero) {
				if (is_file($fichero) && @unlink($fichero)) $borrados++;
			}
		}
		echo "Cache limpiada (BD + custom: $borrados ficheros).";
	}

}
?>
