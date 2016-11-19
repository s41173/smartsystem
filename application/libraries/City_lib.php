<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'city';
    }

    private $ci;

    function combo()
    {
        $this->db->select('id, name');
        $val = $this->db->get('city')->result();
        foreach($val as $row){$data['options'][$row->name] = $row->name;}
        return $data;
    }
    
    function combo_zip()
    {
        $this->db->select('zip');
        $val = $this->db->get('city')->result();
        foreach($val as $row){$data['options'][$row->zip] = $row->zip;}
        return $data;
    }
    
    function combo_district()
    {
        $this->db->select('district');
        $val = $this->db->get('city')->result();
        foreach($val as $row){$data['options'][$row->district] = $row->district;}
        return $data;
    }
    
    function combo_village()
    {
        $this->db->select('village');
        $val = $this->db->get('city')->result();
        foreach($val as $row){$data['options'][$row->zip] = $row->village;}
        return $data;
    }
    
    function get_from_zip($zip,$type)
    {
       $this->db->select($type); 
       $this->db->where('zip', $zip);
       $val = $this->db->get('city')->row();
       if ($val){ return $val; }
    }
    
    function combo_city_ongkir()
    {
        $this->db->select('ongkir_cityname');
        $this->db->order_by('ongkir_cityname', 'asc');
        $val = $this->db->get('ongkir')->result();
        foreach($val as $row){$data['options'][$row->ongkir_cityname] = $this->splits($row->ongkir_cityname);}
        return $data;
    }
    
    function combo_all_city_ongkir()
    {
        $this->db->select('ongkir_cityname');
        $this->db->order_by('ongkir_cityname', 'asc');
        $val = $this->db->get('ongkir')->result();
        $data['options'][""] = " -- Pilih Wilayah -- ";
        foreach($val as $row){$data['options'][$row->ongkir_cityname] = $this->splits($row->ongkir_cityname);}
        return $data;
    }
    
    function get_ongkir($city)
    {
        $this->db->select('ongkir_price');
        $this->db->where('ongkir_service', 'OKE');
        $this->db->where('ongkir_cityname', $city);
        $val = $this->db->get('ongkir')->row();
        return intval($val->ongkir_price);
    }
    
    private function splits($val)
    {
      $res = explode(",",$val); 
      return $res[0];
    }
    
    // ==================================== API ==============================
    
    private function get_province()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
//          CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
          CURLOPT_URL => "http://api.rajaongkir.com/starter/city",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "key: eb7f7529d68f6a2933b5a042ffeeac9d"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {return "cURL Error #:" . $err;} 
        else {  return $response; }
    }
    
    function combo_province()
    {
        $json = $this->get_province();
        $datax = json_decode($json, true);
        $data['options'][""] = " -- Pilih Wilayah -- ";
        foreach ($datax['rajaongkir']['results'] as $row)
        {$data[$row['city_id']] = $row['city_name'];}
        return $data;
    }
    
    function combo_province_name()
    {
        $json = $this->get_province();
        $datax = json_decode($json, true);
        $data['options'][""] = " -- Pilih Wilayah -- ";
        foreach ($datax['rajaongkir']['results'] as $row)
        {$data[$row['city_name']] = $row['city_name'];}
        return $data;
    }
    
    function get_cost_fee($ori,$dest,$weight=1000)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=".$ori."&destination=".$dest."&weight=".$weight."&courier=jne",
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded",
          "key: eb7f7529d68f6a2933b5a042ffeeac9d"
        ),
      ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) 
        { 
//            echo "cURL Error #:" . $err; 
            return 0;
        }
        else 
        { 
          $data = json_decode($response, true); 
          return intval($data['rajaongkir']['results'][0]['costs'][1]['cost'][0]['value']); 
        }
    }


}

/* End of file Property.php */