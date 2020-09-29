<?php

class dbManager
{
    private $mysqli;

    function __construct($serwer, $host, $pass, $db)
    {
        $this->mysqli = new mysqli($serwer, $host, $pass, $db);
        $this->mysqli->set_charset("utf8");
    }

    function __destruct()
    {
        $this->mysqli->close();
    }

    function selectUser($userName, $passwd, $tabela)
    {
        $id = -1;
        $sql = "SELECT * FROM $tabela WHERE userName='$userName'";

        if ($result = $this->mysqli->query($sql)) {
            $num = $result->num_rows;

            if ($num == 1) {
                $row = $result->fetch_object();
                $hash = $row->passwd;

                if (password_verify($passwd, $hash)) {
                    $id = $row->id;
                }
            }
        }

        return $id;
    }

    function select($sql)
    {
        return mysqli_query($this->mysqli, $sql);
    }

    function insert($sql)
    {
        mysqli_query($this->mysqli, $sql);
    }

    function delete($sql)
    {
        mysqli_query($this->mysqli, $sql);
    }

    function update($sql)
    {
        mysqli_query($this->mysqli, $sql);
    }
}
