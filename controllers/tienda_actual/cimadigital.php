<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cimadigital extends CI_Controller {

    public function import() {

        $db = $this->load->database('default', true);
        $query = $db->query("SELECT
        	CONCAT(di2.variante_de, ',',GROUP_CONCAT(di2.item_id)) as IDs,
            count(di2.item_id) + 1 as total
        FROM demo_items di2
        JOIN demo_categories cat2 ON cat_id = di2.item_cat_fk
        JOIN demo_coleccion col2 ON coleccion_id = di2.item_coleccion_id
        WHERE
        	cat2.publico = 1 AND col2.publico2 = 1 AND di2.publico3 = 1 AND di2.activo = 1
        	AND di2.tiene_variantes = 0
        	AND di2.variante_de > 0
        GROUP BY di2.variante_de
        HAVING total > 1");

        $rows = $query->result();
        $data = [];
        $data[0]["id"] = "id";
		$data[0]["ref"] = "ref";
		$data[0]["attributes"] = "attributes";
		$data[0]["value"] = "value";
		$data[0]["supp_ref"] = "supp_ref";
		$data[0]["ean13"] = "ean13";
		$data[0]["upc"] = "upc";
		$data[0]["mpn"] = "mpn";
        $data[0]["supp_price"] = "supp_price";
        $data[0]["impact_price"] = "impact_price";
        $data[0]["ecotax"] = "ecotax";
        $data[0]["quantity"] = "quantity";
        $data[0]["minimal_quantity"] = "minimal_quantity";
        $data[0]["low_stock"] = "low_stock";
        $data[0]["email_quantity"] = "email_quantity";
        $data[0]["impact_weight"] = "impact_weight";
        $data[0]["defaultval"] = "defaultval";
        $data[0]["available_date"] = "available_date";
        $data[0]["default_image"] = "default_image";

        $posicion = 1;
        foreach ($rows as $key => $row) {
            $myids = explode(",", $row->IDs);

            $mainid = $myids[0];
            $mainprice = 0;


            $prequery = "SELECT
            	IF(di1.tiene_variantes = 1, di1.item_id, di1.variante_de) as id,
            	di1.item_ref as ref,
            	'Dimensiones:select:1' as attributes,
            	CONCAT(di1.item_ref, '-',di1.item_ancho,'x',di1.item_largo,':0') as value,
            	di1.item_ref supp_ref,
            	di1.item_ref as ref,
            	di1.item_ref as ean13,
            	di1.item_ref as upc,
            	0 as mpn,
            	0 as supp_price,
            	(di1.item_price - di2.item_price) / 1.21  as impact_price,
            	0 as ecotax,
            	0 as quantity,
            	0 as minimal_quantity,
            	0 as low_stock,
            	0 as email_quantity,
            	0 as impact_weight,
            	0 as defaultval,
            	CURDATE() as available_date,
            	0 as default_image
            FROM
                demo_items di1
            JOIN
            	demo_items di2 ON di2.item_id = IF(di1.variante_de > 0, di1.variante_de, di1.item_id)
            WHERE
            	di1.item_id IN (
            		SELECT di3.item_id FROM demo_items di3 WHERE di3.item_id IN (
            			SELECT di3.item_id FROM demo_items WHERE di3.tiene_variantes = 1 AND di3.item_id = {$mainid}
            		) OR variante_de IN (
            			SELECT item_id FROM demo_items di4 WHERE di4.tiene_variantes = 1 AND di4.item_id = {$mainid}
            		)
            	)
            ORDER BY di1.item_id ASC";
            //echo $prequery."<br>";
            $query = $db->query($prequery);

            $combinations = $query->result();
            foreach ($combinations as $key => $combination) {
                $data[$posicion]["id"] = $combination->id;
        		$data[$posicion]["ref"] = $combination->ref;
        		$data[$posicion]["attributes"] = $combination->attributes;
        		$data[$posicion]["value"] = $combination->value;
        		$data[$posicion]["supp_ref"] = $combination->supp_ref;
        		$data[$posicion]["ean13"] = $combination->ean13;
        		$data[$posicion]["upc"] = $combination->upc;
        		$data[$posicion]["mpn"] = $combination->mpn;
                $data[$posicion]["supp_price"] = $combination->supp_price;
                $data[$posicion]["impact_price"] = $combination->impact_price;
                $data[$posicion]["ecotax"] = $combination->ecotax;
                $data[$posicion]["quantity"] = $combination->quantity;
                $data[$posicion]["minimal_quantity"] = $combination->minimal_quantity;
                $data[$posicion]["low_stock"] = $combination->low_stock;
                $data[$posicion]["email_quantity"] = $combination->email_quantity;
                $data[$posicion]["impact_weight"] = $combination->impact_weight;
                $data[$posicion]["defaultval"] = $combination->defaultval;
                $data[$posicion]["available_date"] = $combination->available_date;
                $data[$posicion]["default_image"] = $combination->default_image;

                $posicion ++;
            }
        }

        $filename = "website_data_" . date('Ymd') . ".csv";
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: text/csv;");
		header("Pragma: no-cache");
		header("Expires: 0");/**/

		echo $this->generateCsv($data);

    }

    public function filterData($str) {
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
		$str = str_replace('&#34;', '', $str);
		$str = str_replace('&#39;', '`', $str);
		$str = str_replace('&#13;', ' ', $str);
		$str = str_replace('&#10;', ' ', $str);
		$str = utf8_decode($str);
		return $str;
   }

	function generateCsv($data, $delimiter = ';', $enclosure = '"') {
		$contents = "";
		$handle = fopen('php://temp', 'r+');
		foreach ($data as $line) {
			fputcsv($handle, $line, $delimiter, $enclosure);
		}
		rewind($handle);
		while (!feof($handle)) {
			$contents .= fread($handle, 8192);
		}
		fclose($handle);
		return $contents;
	}

}
