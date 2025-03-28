<?php

class Post
{
    // Veritabanı bağlantısı
    private $conn;
    private $table = 'posts';

    // Post Özellikleri
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $create_at;

    // Constructor (Kurucu Metod)
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Tüm gönderileri oku
    public function read()
    {
        $query = 'SELECT 
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.create_at 
        FROM ' . $this->table . ' p
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY p.create_at DESC';

        // Sorguyu hazırla ve çalıştır
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        $query = 'SELECT 
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.create_at 
    FROM ' . $this->table . ' p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.id = ? LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        //execute
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' (title, body, author, category_id) VALUES (:title, :body, :author, :category_id)';
        $stmt = $this->conn->prepare($query);

        // XSS koruması
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Değerleri bağla
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        // Sorguyu çalıştır
        if ($stmt->execute()) {
            return true;
        }

        // Hata durumunu yazdır
        printf("Error: %s.\n", implode(" | ", $stmt->errorInfo()));
        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' 
              SET title = :title, body = :body, author = :author, category_id = :category_id
              WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // XSS koruması
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Değerleri bağla
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        // Sorguyu çalıştır
        if ($stmt->execute()) {
            return true;
        }

        // Hata durumunu yazdır
        printf("Error: %s.\n", implode(" | ", $stmt->errorInfo()));
        return false;
    }

    //delete func
    public function delete()
    {
        // Doğru SQL sorgusu
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    
        // SQL sorgusunu hazırla
        $stmt = $this->conn->prepare($query);
    
        // Veriyi temizle
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        // Parametreyi bağla
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    
        // Sorguyu çalıştır ve sonucu döndür
        if ($stmt->execute()) {
            return true;
        }
    
        // Hata mesajı bas
        printf("Error: %s.\n", implode(" | ", $stmt->errorInfo()));
        return false;
    }
    
}
