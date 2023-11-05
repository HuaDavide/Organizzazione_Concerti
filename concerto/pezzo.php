<?php

class Pezzo
{
    private $id;
    private $codice;
    private $titolo;

    public function GetId()
    {
        return $this->id;
    }

    public function SetCodice($codice)
    {
        $this->codice = $codice;
    }
    public function GetCodice()
    {
        return $this->codice;
    }
    public function SetTitolo($titolo)
    {
        $this->titolo = $titolo;
    }
    public function GetTitolo()
    {
        return $this->titolo;
    }

    public function Show()
    {
        echo "\nID = " . $this->id . "\n";
        echo "CODICE = " . $this->codice . "\n";
        echo "TITOLO = ". $this->titolo . "\n";
    }
}