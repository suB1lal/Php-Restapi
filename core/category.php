<?php

class Category
{
    // Veritabanı bağlantısı
    private $conn;
    private $table = 'categories';

    // kategori Özellikleri
    public $id;
    public $name;
    public $create_at;

    // Constructor (Kurucu Metod)
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Tüm gönderileri oku
    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table;

        // Sorguyu hazırla ve çalıştır
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
