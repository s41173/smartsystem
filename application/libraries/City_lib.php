<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'kabupaten';
    }

    private $ci;
       
    private function splits($val)
    {
      $res = explode(",",$val); 
      return $res[0];
    }
    
    // ==================================== API ==============================
    
    private function get_city()
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
        $json = $this->get_city();
        $datax = json_decode($json, true);
        $data['options'][""] = " -- Pilih Wilayah -- ";
        foreach ($datax['rajaongkir']['results'] as $row)
        {$data[$row['province']] = $row['province'];}
        return $data;
    }
    
    function combo_city()
    {
        $json = $this->get_city();
        $datax = json_decode($json, true);
        $data['options'][""] = " -- Pilih Kabupaten / Kota -- ";
        foreach ($datax['rajaongkir']['results'] as $row)
        {$data[$row['city_id']] = $row['city_name'];}
        return $data;
    }
    
    function combo_city_db()
    {
//        $this->db->select('nama');
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){$data['options'][$row->id] = $row->nama;}
        return $data;
    }
    
    function combo_city_name()
    {
        $json = $this->get_city();
        $datax = json_decode($json, true);
        $data['options'][""] = " -- Pilih Kabupaten / Kota -- ";
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