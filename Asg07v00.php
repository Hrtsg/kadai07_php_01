<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $docID_dict = [
        "商船三井" => "S100STH6",
        "日本郵船" => "S100SS7P",
        "玉井商船株式会社" => "S100STLS",
        "川崎汽船" => "S100SRTI",
        "飯野海運" => "S100SP9O",
    ];

    $data = [];
    // var_dump($data);
    foreach ($docID_dict as $companyName => $docID) {
        $csv_savedir = $docID . "/XBRL_TO_CSV";
        if (is_dir($csv_savedir)) {
            $files = scandir($csv_savedir);
            foreach ($files as $file) {
                if (strpos($file, "jpcrp040300-01") === 0) {
                    $filepath = $csv_savedir . '/' . $file;
                    if (($handle = fopen($filepath, "r")) !== false) {
                        $headers = fgetcsv($handle, 0, "\t");
                        while (($row = fgetcsv($handle, 0, "\t")) !== false) {
                            $rowData = array_combine($headers, $row);
                            $rowData["会社名"] = $companyName;
                            $data[] = $rowData;
                        }
                        fclose($handle);
                        var_dump($data);
                    }
                }
            }
        }
    }
    //  echo json_encode($data,JSON_PRETTY_PRINT);
    // var_dump($data);
    return $data;
    echo ('finish!');
}
?>
