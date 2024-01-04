<?php
class Database {
    public $con;
    protected $servername = "dpg-cm7f467qd2ns73f3efi0-a.singapore-postgres.render.com";
    protected $username = "camnguyen";
    protected $password = "KR8xFyagjVwqPldo8LrBfCNlN63GHMAY";
    protected $dbname = "cnote";

    function __construct() {
        $this->con = new PDO("pgsql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
        $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}