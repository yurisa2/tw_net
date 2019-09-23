<?php
/**
 * A file splitter function for php
 * Can split a file to number of parts depending on the buffer size given
 *
 * @author manujith pallewatte [manujith.nc@gmail.com]
 * @date   30/10/13
 *  *
 * @param  $file String
 * Path of the file to split
 * @param $buffer number
 * The [maximum] size of the part of a file
 * @return array S
 * et of strings containing the paths to the parts
 */
function fsplit($file,$store_path,$buffer=1024){
    //open file to read
    $file_handle = fopen($file,'r');
    //get file size
    $file_size = filesize($file);
    //no of parts to split
    $parts = $file_size / $buffer;

    //store all the file names
    $file_parts = array();

    //name of input file
    $file_name = basename($file);

    for($i=0;$i<$parts;$i++){
        //read buffer sized amount from file
        $file_part = fread($file_handle, $buffer);
        //the filename of the part
        $file_part_path = $store_path.$file_name.".part$i";
        //open the new file [create it] to write
        $file_new = fopen($file_part_path,'w+');
        //write the part of file
        fwrite($file_new, $file_part);
        //add the name of the file to part list [optional]
        array_push($file_parts, $file_part_path);
        //close the part file handle
        fclose($file_new);
    }
    //close the main file handle
    fclose($file_handle);
    return $file_parts;
}

echo '<pre>';

$target_dir = __DIR__ . '/../files/temp/';
$target_dir_split = __DIR__ . '/../files/temp_split/';
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
$uploadOk = 1;


$set_name = $_POST["set"];

// var_dump($target_dir); //DEBUG

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

      $files = (fsplit($target_file,$target_dir_split,1024));

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$file_list = array();

foreach ($files as $key => $value) {
  $file_list[] = ['file' => $value,
                  'set' => $set_name
];
}

// var_dump(json_encode($file_list)); //DEBUG

$json_file = __DIR__ . '/../files/file_list.json';

$json_file_contents_on_file = file_get_contents($json_file);
$json_file_contents_on_file = json_decode($json_file_contents_on_file);

// var_dump($json_file_contents_on_file); //DEBUG
// var_dump($file_list);

if($json_file_contents_on_file != NULL) {
  $json_file_contents = array_merge($file_list,$json_file_contents_on_file);
} else {
  // echo "Null"; //DEBUG
  $json_file_contents = $file_list;
}

// var_dump($json_file_contents); //DEBUG

$json_file_contents = json_encode($json_file_contents);

file_put_contents($json_file,$json_file_contents);


// Send File
// Split File by N bytes (512k)
// register at a json with a filename and set description


?>
