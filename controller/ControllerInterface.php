<?php
interface ControllerInterface {
   //aquesta interfície fa una declaració dels mètodes que seran obligatoris de complir per tots
   //els controladors que implementin aquesta interfície. 
   //En pinicpi hauríem de tenir-ho implementat a tots els nostres controladors ja que té el nom
   //d'accions bàsiques que acabarem fent a tots els controladors
    public function processRequest();
    public function add();
    public function modify();
    public function delete();
    public function searchById();
    public function home();
    
}
