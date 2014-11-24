<?php
	$uploadOk = 0;
	//die(json_encode(array("Fotos"=>$value)));
	$files = [];
	foreach ($_FILES as $key => $value) {
		$uploadOk = 1;
		$target_dir = getcwd()."/uploads/";
		//print_r($value);
		$tmp_name = explode('/', $value["tmp_name"]);
		$tmp_name = explode('.', $tmp_name[count($tmp_name)-1]);
		$tmp_name = $tmp_name[0];
		$target_file = $target_dir.explode('\\', $tmp_name.basename($value["name"]))[3];
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$check = getimagesize($value["tmp_name"]);
		if($check !== false) {
			if (file_exists($target_file)) {
			    //echo "Sorry, file already exists.";
			    $uploadOk = 0;
			}else{
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" ) {
				    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				    $uploadOk = 0;
				}else{
					if (is_uploaded_file($value["tmp_name"])) {
						if (move_uploaded_file($value["tmp_name"], $target_file)) {
					        $foto = $tmp_name.$value["name"];
					        //echo($foto);
					    } else {
					       //echo "Sorry, there was an error uploading your file.";
					    }
					}
				}
			}
		}
		if ($uploadOk) {
			$files[] = $foto;
		}
	}
	header("Content-type: application/json");
	echo json_encode($files);
?>