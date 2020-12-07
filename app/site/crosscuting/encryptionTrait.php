<?php

namespace app\site\crosscuting;

trait EncryptionTrait{

    function encryption($str, $privateKey){
        return md5($str . $privateKey);
    }


}