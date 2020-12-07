<?php

namespace app\crosscuting;

use app\site\crosscuting\Log;

class UploadFiles{
    
    static public function uploadImage($targetDir, $fileField)
    {
        $fotoNomeFinal = date('dmYhis') . "_" .  basename($_FILES[$fileField]["name"]);
        $target_file = $targetDir . "/" . $fotoNomeFinal;
        $uploadOk = 1;
        
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $check = getimagesize($_FILES[$fileField]["tmp_name"]);
        if ($check !== false) {    
            $uploadOk = 1;
        } else {
            Log::info("Arquivo não é imagem");
            $uploadOk = 0;
        }
    
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            Log::info("Somente imagem JPG, JPEG, PNG & GIF são permitidas.");
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {            
            return false;
        } else {
            if (move_uploaded_file($_FILES[$fileField]["tmp_name"], $target_file)) {            
                return $fotoNomeFinal;
            } else {
                Log::info("Falha ao mover imagem temporária");
                return false;
            }
        }
    }
}