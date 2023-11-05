<?php

class Sala
{
    private $id;
    private $codice;
    private $nome;
    private $capienza;

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

    public function SetNome($nome)
    {
        $this->nome = $nome;
    }
    public function GetNome()
    {
        return $this->nome;
    }
    
    public function SetCapienza($capienza)
    {
        $this->capienza = $capienza;
    }
    public function GetCapienza()
    {
        return $this->capienza;
    }

    public function Show()
    {
        echo "\nID = " . $this->id . "\n";
        echo "CODICE = " . $this->codice . "\n";
        echo "NOME = " . $this->nome . "\n";
        echo "CAPIENZA = " . $this->capienza . "\n";
    }
}