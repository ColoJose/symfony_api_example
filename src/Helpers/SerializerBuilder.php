<?php


namespace App\Helpers;


use Symfony\Component\Serializer\Serializer;

class SerializerBuilder {

    public function build($normalizers, $encoders): Serializer {
        return new Serializer($normalizers, $encoders);
    }

}