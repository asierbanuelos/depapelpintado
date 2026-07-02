<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RedirectHook {

    public function check() {
        $CI =& get_instance();

        // No aplicar redirecciones en el panel de administración
        if (strpos($CI->uri->uri_string(), 'admin_library') !== false) return;

        $uri = '/' . ltrim($CI->uri->uri_string(), '/');
        // Quitar query string si lo hubiera (CI normalmente ya lo hace)
        if (($q = strpos($uri, '?')) !== false) $uri = substr($uri, 0, $q);

        $row = $CI->db
            ->select('id, url_to')
            ->where('url_from', $uri)
            ->get('demo_redirects')
            ->row();

        if ($row) {
            $CI->db->where('id', $row->id)->set('hits', 'hits+1', FALSE)->update('demo_redirects');
            header('Location: ' . $row->url_to, true, 301);
            exit();
        }
    }

}
