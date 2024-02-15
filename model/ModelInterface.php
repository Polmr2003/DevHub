<?php

interface ModelInterface
{

    public function add($object);

    public function modify($object);

    public function delete($id);

    public function searchById($id);

    public function home();

}
