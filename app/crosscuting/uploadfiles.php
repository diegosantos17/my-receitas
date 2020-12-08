<?php

namespace app\crosscuting;

use Exception;

class UploadFiles{
    
    static public function uploadImage($targetDir, $fileField)
    {
        $fotoNomeFinal = '';
        
        if(!empty($_FILES[$fileField]["name"])){
            $fotoNomeFinal = date('dmYhis') . "_" .  basename($_FILES[$fileField]["name"]);
            $target_file = $targetDir . "/" . $fotoNomeFinal;
            
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            $check = getimagesize($_FILES[$fileField]["tmp_name"]);
            if ($check === false) {    
                throw new Exception("Apenas imagens são aceitas.");            
            }
        
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                throw new Exception("Somente imagem JPG, JPEG, PNG & GIF são permitidas.");
            }

            if (!move_uploaded_file($_FILES[$fileField]["tmp_name"], $target_file)) {                            
                throw new Exception("Falha ao registrar imagem. Contate o administrador.");
            }   
        }

        return $fotoNomeFinal;
    }
}