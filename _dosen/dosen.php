<?php
    // definisi objek:
    // Setiap objek dosen memiliki:
    //  - Nama (+ Gelar, proccessed)
    //  - Nama (+ Gelar, raw)
    //  - Daftar ajar (Array, Hanya ID) [soon]
    //  - Daftar ajar (Array, Hanya Nama Mata Kuliah) [soon]
    //  - Alamat Email
    //  - Homepage.

    $dosen = [];

    $rawdata = file_get_contents('rawdata.juklak.md');

    $lecturer = [];
    preg_match_all("/\* ([\w\.\ \,\(\)\;\&\–\-]+)(\, Studi[\w\.\-\s]|:)/imU", $rawdata, $lecturer);
    
    $email = [];
    preg_match_all("/([\w\.]+\@([\w]+[\w\.]+))/im", $rawdata, $email);

    //var_dump($lecturer);
    //var_dump($email[1]);

    for($i=0; $i<count($lecturer[1]); $i++) {
        $cleanname = preg_replace("/ \([\w\ \.\,\-\–]+\)/", "", $lecturer[1][$i]);
        $cleanname = str_replace(" &amp;", ",", $cleanname);
        $cleanname = str_replace(" &", ",", $cleanname);
        $dosen[] = [
            "name" => $cleanname,
            "name_raw" => html_entity_decode($lecturer[1][$i]),
            "homepage" => null,
            "email" => $email[1][$i]
        ];
    }

    //var_dump($dosen);
    file_put_contents("../dosen.min.json", json_encode($dosen));
    file_put_contents("../dosen.json", json_encode($dosen, JSON_PRETTY_PRINT));