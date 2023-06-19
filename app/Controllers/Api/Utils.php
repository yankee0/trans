<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Utils extends BaseController
{
    public function checkDoubleContainer()
    {
        $data = $this->request->getVar('data');
        $str1 = explode('-', $data[0]);
        $str2 = explode('-', $data[1]);

        for ($i=0; $i < sizeof($str1); $i++) { 
            $str1[$i] =  strtoupper($str1[$i]);
        }
        for ($i=0; $i < sizeof($str2); $i++) { 
            $str2[$i] =  strtoupper($str2[$i]);
        }

        $count = 0;
        $err = [];

        for ($i = 0; $i < sizeof($str1); $i++) {
            for ($j = 0; $j < sizeof($str1); $j++) {
                if ($str1[$i] == $str1[$j]) {
                    $count++;
                }
            }
            if ($i == (sizeof($str1) - 1)) {
                if ($count > 1) {
                    if (!empty($str1[$i])) {
                        $str = 'Doublon de ' . $str1[$i] . ' dans les conteneurs 20\'.';
                        array_push($err, $str);
                    }
                }
            }
            $count = 0;
        }

        for ($i = 0; $i < sizeof($str2); $i++) {
            for ($j = 0; $j < sizeof($str2); $j++) {
                if ($str2[$i] == $str2[$j]) {
                    $count++;
                }
            }
            if ($i == (sizeof($str2) - 1)) {
                if ($count > 1) {
                    if (!empty($str2[$i])) {
                        $str = 'Doublon de ' . $str2[$i] . ' dans les conteneurs 40\'.';
                        array_push($err, $str);
                    }
                }
            }
            $count = 0;
        }

        $diff_pack = array_diff($str1, $str2);
        foreach ($str1 as $s) {
            if (!in_array($s, $diff_pack)) {
                if (!empty($s)) {
                    $str = 'Doublon de ' . $s . ' dans les conteneurs 20\' et 40\'.';
                    array_push($err, $str);
                }
            }
        }

        $data = [
            'm' => (sizeof($err) == 0) ? true : false,
            'err' => $err
        ];

        $this->response->setJSON($data)->send();
    }
}
