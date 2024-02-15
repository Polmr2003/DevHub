<?php

/**
 * Pet DTO class.
 */
class Pet
{
    // ATTRIBUTES

    private $id;
    private $idOwner;
    private $name;

    // CONSTRUCTOR

    public function __construct ($id, $idOwner, $name=NULL)
    {
        $this->id = $id;
        $this->idOwner = $idOwner;
        $this->name = $name;
    }
    
    // GETTERS & SETTERS

    public function getId      (      ) { return $this->id;        }

    public function getIdOwner (      ) { return $this->idOwner;   }
    public function setIdOwner ($value) { $this->idOwner = $value; }

    public function getName    (      ) { return $this->name;       }
    public function setName    ($value) { $this->name = $value;     }

    // WRITE

    public function write ()
    {
        return "\n".$this->id . ";" . $this->idOwner . ";" . $this->name;
    }
}