<?php

namespace models;

abstract class BaseModel
{
    abstract public  function toArray(): array;

    abstract static public function fromAssoc($data): BaseModel;
}