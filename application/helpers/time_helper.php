<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function tgleng($tgl)
{
    if ($tgl != "")
    {
        // Konversi hari dan tanggal ke dalam format Indonesia
        $hari_array = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        $hr = date('w', strtotime($tgl));
        $hari = $hari_array[$hr];
        $tgl = date('d-m-Y', strtotime($tgl));
        $hr_tgl = "$hari, $tgl";
        return $hr_tgl;
    }
}

function waktuindo()
{
      // Ambil waktu server terkini
      $dat_server = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date("Y"));
     // echo 'Waktu server (US): '.date("H:i:s", $dat_server);
      // Ambil perbedaan waktu server dengan GMT
      $diff_gmt = substr(date("O",$dat_server),1,2);
      // karena perbedaan waktu adalah dalam jam, maka kita jadikan detik
      $datdif_gmt = 60 * 60 * $diff_gmt;
      // Hitung perbedaannya

      if (substr(date("O",$dat_server),0,1) == '+') {
      $dat_gmt = $dat_server - $datdif_gmt;
      } else {
      $dat_gmt = $dat_server + $datdif_gmt;
      }
       //      echo 'Waktu GMT: '.date("H:i:s", $dat_gmt);

      // Hitung perbedaan GMT dengan waktu Indonesia (GMT+7)

      // karena perbedaan waktu adalah dalam jam, maka kita jadikan detik
      $datdif_id = 60 * 60 * 7;
      $dat_id = $dat_gmt + $datdif_id;
      return date("H:i:s", $dat_id);
}