<?php
include "db_manager.php";
include "sala.php";
include "pezzo.php";

class Concerto
{
    private $id;
    private $codice;
    private $titolo;
    private $descrizione;
    private $data;
    private $sala_id;

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

    public function SetDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }

    public function GetDescrizione()
    {
        return $this->descrizione;
    }

    public function setData($data)
    {
        $this->data = $data;
    }
    public function GetData()
    {
        return $this->data;
    }

    private static function Connect()
    {
        $database = new DataBase("config.txt");
        $pdo = $database->CONNECT();

        return $pdo;
    }

    public static function Create($params)
    {
        $pdo = self::Connect();

        try
        {
            $stmt = $pdo->prepare("INSERT INTO concerti(codice, titolo, descrizione, data, sala_id) VALUES (:codice, :titolo, :descrizione, :data, :sala_id)");

            $stmt->bindParam(':codice', $params['codice']);
            $stmt->bindParam(':titolo', $params['titolo']);
            $stmt->bindParam(':descrizione', $params['descrizione']);
            $stmt->bindParam(':data', $params['data']);
            $stmt->bindParam(':sala_id', $params['sala_id']);

            $stmt->execute();

            $stmt = $pdo->prepare("SELECT * FROM concerti ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            return $stmt->fetchObject(__CLASS__);

        } catch (PDOException $e) {

            return false;

        }

    }

    public function Show()
    {
        echo "\nID = " . $this->id . "\n";
        echo "CODICE = " . $this->codice . "\n";
        echo "TITOLO = " . $this->titolo . "\n";
        echo "DESCRIZIONE = " . $this->descrizione . "\n";
        echo "DATA = " . $this->data . "\n";
    }

    public static function Find($id)
    {
        $pdo = self::Connect();

        try
        {
            $stml = $pdo->prepare("SELECT * FROM concerti WHERE id = :id");
            $stml->bindParam(":id", $id);
            $stml->execute();
            return $stml->fetchObject(__CLASS__);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function FindAll()
    {
        $pdo = self::Connect();

        try
        {
            $stmt = $pdo->prepare("SELECT * FROM concerti");

            $stmt->execute();
            $pdo = null;
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function Delete()
    {
        $pdo = self::Connect();

        try
        {
            $stmt = $pdo->prepare("DELETE FROM concerti WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            $pdo = null;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function Update($params)
    {
        $pdo = self::Connect();

        try
        {
            $stmt = $pdo->prepare("UPDATE concerti SET codice = :codice, titolo = :titolo, descrizione = :descrizione, data = :data WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':codice', $params['codice']);
            $stmt->bindParam(':titolo', $params['titolo']);
            $stmt->bindParam(':descrizione', $params['descrizione']);
            $stmt->bindParam(':data', $params['data']);
            $stmt->execute();

            $stmt = $pdo->prepare("SELECT * FROM concerti WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            $pdo = null;
            return $stmt->fetchObject(__CLASS__);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function Sala()
    {
        $pdo = self::Connect();

        try
        {
            $stmt = $pdo->prepare("SELECT * from sale WHERE id = :id");
            $stmt->bindParam(':id', $this->sala_id);
            $stmt->execute();
            $pdo = null;
            return $stmt->fetchObject("Sala");
        } catch (PDOException $e) {
            return false;
        }
    }

    public function Pezzi()
    {
        $pdo = self::Connect();

        try
        {
            $stmt = $pdo->prepare("select p.* from pezzi p inner join concerti_pezzi cp ON cp.pezzo_id = p.id where cp.concerto_id = :id;");
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, "Pezzo");
        }   
        catch (PDOException $e) 
        {
            return false;
        }
    }
}

$params = [];

do {
    echo "\n[1] Crea oggetto\n";
    echo "[2] Visualizza oggetto\n";
    echo "[3] Aggiorna oggetto\n";
    echo "[4] Elimina oggetto\n";
    echo "[5] Visualizza tutti i record della tabella\n";
    echo "[6] Visualizza sala\n";
    echo "[7] Visualizza pezzi\n";
    echo "[0] Esci\n";

    $scelta = readline("Scegli l'opzione: ");
    switch ($scelta) {
        case 1:
            echo "\n";
            $params['codice'] = readline("Inserisci il codice:");
            $params['titolo'] = readline("Inserisci il titolo:");
            $params['descrizione'] = readline("Inserisci la descizione:");
            $params['data'] = readline("Inserisci la data:");
            $params['sala_id'] = readline("Inserisci il sala id:");
            if(Concerto::Create($params) == false)
                echo "Errore inserimento\n";
            break;
        case 2:
            $id = readline("Inserisci id del record che vuoi visualizzare:");
            $concerto = Concerto::Find($id);
            if($concerto != false)
                $concerto->Show();
            else
                echo("id non presente\n");
            break;
        case 3:
            $id = readline("Inserisci id del record che vuoi modificare:");
            $concerto = Concerto::Find($id);
            
            if($concerto == false)
                echo("id non presente\n");
            else
            {
                $params['codice'] = readline("Inserisci il codice:");
                $params['titolo'] = readline("Inserisci il titolo:");
                $params['descrizione'] = readline("Inserisci la descizione:");
                $params['data'] = readline("Inserisci la data:");
                $params['sala_id'] = readline("Inserisci il sala id:");

                if($concerto->Update($params) == false)
                    echo("Errore aggiornamento\n");
            }

            break;
        case 4:

            $id = readline("Inserisci id del record che vuoi cancellare:");
            $concerto = Concerto::Find($id);

            if($concerto != false)
                $concerto->Delete();
            else
                echo("id non presente\n");
            break;
        case 5:
            $tabella = Concerto::FindAll();
            for ($i = 0; $i < count($tabella); $i++) {
                $tabella[$i]->Show();
            }
            break;
        case 6:
            $id = readline("Inserisci id del record che vuoi visualizzare la sala:");
            $concerto = Concerto::Find($id);

            if($concerto != false)
            {
                $sala = $concerto->Sala();
            }
            else
                echo("id non presente\n");

            break;
        case 7:
            $id = readline("Inserisci id del record che vuoi visualizzare i pezzi:");
            $concerto = Concerto::Find($id);

            if($concerto != false)
            {
                $pezzi = $concerto->Pezzi();

                foreach($pezzi as $pezzo)
                { 
                    $pezzo->Show();
                }
                
            }
            else
                echo("id non presente\n");
    }
} while ($scelta != 0);
