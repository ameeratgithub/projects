<?php
/**
 * Created by PhpStorm.
 * User: Ameer Hamza
 * Date: 9/27/2017
 * Time: 12:42 AM
 */

namespace App\Helpers;


class Message
{
    private $message;
    public function __construct()
    {
    $this->message=(object)[
        'type'=>null,
        'text'=>null
    ];
    }

    public function getMessage($type,$action,$entity){

        $this->message->type=$type;
        if($type==='info')
        $this->message->text=ucfirst($entity)." has been".$action."ed successfully...!";
        else if($type==='error')
            $this->message->text=ucfirst($entity)." has been".$action."ed successfully...!";
        return $this->message;
    }
}