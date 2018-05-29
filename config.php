<?php
class DB {
    //Banco de dados online
//   public $host = 'magiclink.mysql.uhserver.com';
//   public $user = 'devgti';
//   public $password = 'projetopratica@5';
//   public $database = 'magiclink';
//   public $charset = 'utf8';
    //Banco de dados local
    public $host = 'localhost';
    public $user = 'root';
    public $password = '';
    public $database = 'magiclink';
    public $charset = 'utf8';

    public function DBconnect() {
        $con = mysqli_connect($this->host, $this->user, $this->password, $this->database) or die(mysqli_connect_error());
        mysqli_set_charset($con, $this->charset) or die(mysqli_error($con));
        return $con;
    }

    public function DBclose($con) {
        mysqli_close($con) or die(mysqli_error($con));
    }

}
