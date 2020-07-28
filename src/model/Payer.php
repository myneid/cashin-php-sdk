<?php


namespace Directa24\model;

class Payer
{
    public static $SERIAL_VERSION_UID = 1;

    public $id;

    public $document;

    public $document_type;

    public $email;

    public $first_name;

    public $last_name;

    public $address;

    public $phone;
}
