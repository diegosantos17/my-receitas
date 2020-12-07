<?php

namespace app\crosscuting;

trait EncryptionTrait{

    function encryption($str, $privateKey){
        return md5($str . $privateKey);
    }


}