<?php
class book {
    private $id;
    private $title;
    private $autor;
    private $genre;
    private $status;

    public function __construct($id, $title, $autor, $genre, $status = "disponible") {
        $this->id = $id;
        $this->title = $title;
        $this->autor = $autor;
        $this->genre = $genre;
        $this->status = $status;
    }
    public function getId() {
        return $this->id;
    }

    public function gettitle() {
        return $this->title;
    }

    public function settitle($title) {
        $this->title = $title;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function setAutor($autor) {
        $this->autor = $autor;
    }

    public function getgenre() {
        return $this->genre;
    }

    public function setgenre($genre) {
        $this->genre = $genre;
    }

    public function getstatus() {
        return $this->status;
    }

    public function setstatus($status) {
        $this->status = $status;
    }

    public function editBook($title, $autor, $genre) {
        $this->title = $title;
        $this->autor = $autor;
        $this->genre = $genre;
    }
}

class Library {
    private $book = [];

    public function addBook($book) {
        $this->book[$book->getId()] = $book;
    }

    public function editBook($id, $newtitle, $newAutor, $nuevagenre) {
        if (isset($this->book[$id])) {
            $this->book[$id]->editBook($newtitle, $newAutor, $nuevagenre);
        }
    }

    public function deleteBook($id) {
        if (isset($this->book[$id])) {
            unset($this->book[$id]);
        }
    }

    public function searchBook($criterio) {
        $resultados = [];
        foreach ($this->book as $book) {
            if (stripos($book->gettitle(), $criterio) !== false || stripos($book->getAutor(), $criterio) !== false || stripos($book->getgenre(), $criterio) !== false) {
                $resultados[] = $book;
            }
        }
        return $resultados;
    }

    public function borrowBook($id) {
        if (isset($this->book[$id]) && $this->book[$id]->getstatus() === "disponible") {
            $this->book[$id]->setstatus("prstatus");
            return true;
        }
        return false;
    }

    public function returnBook($id) {
        if (isset($this->book[$id]) && $this->book[$id]->getstatus() === "prstatus") {
            $this->book[$id]->setstatus("disponible");
            return true;
        }
        return false;
    }

    public function availablebook() {
        $disponibles = [];
        foreach ($this->book as $book) {
            if ($book->getstatus() === "disponible") {
                $disponibles[] = $book;
            }
        }
        return $disponibles;
    }

    public function selectBook() {
        return $this->book;
    }
}


$Library = new Library();

$book1 = new book(1,"Cien Años de Soledad", "Gabriel García Márquez", "Novela");
$book2 = new book(2,"El Gran Gatsby", "F. Scott Fitzgerald", "Novela");
$book3 = new book(3,"Don Quijote de la Mancha", "Miguel de Cervantes", "Clásico");
$book4 = new book(4,"Metamorfosis", "Franz Kafka", "fantasia");
$book5 = new book(5,"Hamlet", "William Shakespeare", "tragedia");
$book6 = new book(6,"Sherlock Holmes", "Sir Arthur Conan Doyle", "Policial");
$book7 = new book(7,"Harry Potter y la Piedra Filosofal", "J.K. Rowling", "Fantasía");
$book8 = new book(8,"El Hobbit", "J.R.R. Tolkien", "Fantasía");

$Library->addBook($book1);
$Library->addBook($book2);
$Library->addBook($book3);
$Library->addBook($book4);
$Library->addBook($book5);
$Library->addBook($book6);

$Library->borrowBook(4);

$bookDisponibles = $Library->availablebook();
echo "libros disponibles actualmente, ojala no se roben los que se prestan: \n";
foreach ($bookDisponibles as $book) {
    echo "ID: " . $book->getId() . " - titulo del libro: " . $book->gettitle() . " - Autor: " . $book->getAutor() . "\n";
}

$Library->returnBook(4);

$bookDisponibles = $Library->availablebook();
echo "libros disponibles actualmente, no te los robes si los prestas:\n";
foreach ($bookDisponibles as $book) {
    echo "ID: " . $book->getId() . " - titulo del libro: " . $book->gettitle() . " - Autor: " . $book->getAutor() . "\n";
}
?>
