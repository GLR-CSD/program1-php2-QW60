<?php
// Set strict types
declare(strict_types=1);

class Album {
    /** @var int|null Het ID van het album */
    private ?int $ID;

    /** @var string De naam van het album */
    private string $naam;

    /** @var string De artiest(en) van het album */
    private string $artiesten;

    /** @var string De releasedatum van het album */
    private string $release_datum;

    /** @var string De URL van het album */
    private string $URL;

    /** @var string De afbeeldingslocatie van het album */
    private string $afbeelding;

    /** @var float De prijs van het album */
    private float $prijs;

    /**
     * Constructor voor het maken van een Album object.
     *
     * @param int|null $ID Het ID van het album.
     * @param string $naam De naam van het album.
     * @param string $artiesten De artiest(en) van het album.
     * @param string $release_datum De releasedatum van het album.
     * @param string $URL De URL van het album.
     * @param string $afbeelding De afbeeldingslocatie van het album.
     * @param float $prijs De prijs van het album.
     */
    public function __construct(?int $ID, string $naam, string $artiesten, string $release_datum, string $URL, string $afbeelding, float $prijs)
    {
        $this->ID = $ID;
        $this->naam = $naam;
        $this->artiesten = $artiesten;
        $this->release_datum = $release_datum;
        $this->URL = $URL;
        $this->afbeelding = $afbeelding;
        $this->prijs = $prijs;
    }

    /**
     * Haalt alle albums op uit de database.
     *
     * @param PDO $db De PDO-databaseverbinding.
     * @return Album[] Een array van Album-objecten.
     */
    public static function getAll(PDO $db): array
    {
        // Voorbereiden van de query
        $stmt = $db->query("SELECT * FROM Album");

        // Array om albums op te slaan
        $albums = [];

        // Itereren over de resultaten en albums toevoegen aan de array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $album = new Album(
                $row['ID'],
                $row['naam'],
                $row['artiesten'],
                $row['release_datum'],
                $row['URL'],
                $row['afbeelding'],
                $row['prijs']
            );
            $albums[] = $album;
        }

        // Retourneer array met albums
        return $albums;
    }

    /**
     * Zoek albums op basis van ID.
     *
     * @param PDO $db De PDO-databaseverbinding.
     * @param int $ID Het unieke ID van een album waarnaar we zoeken.
     * @return Album|null Het gevonden Album-object of null als er geen overeenkomstig album werd gevonden.
     */
    public static function findById(PDO $db, int $ID): ?Album
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("SELECT * FROM Album WHERE ID = :ID");
        $stmt->bindParam(':ID', $ID);
        $stmt->execute();

        // Retourneer een album als gevonden, anders null
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Album(
                $row['ID'],
                $row['naam'],
                $row['artiesten'],
                $row['releaseDatum'],
                $row['URL'],
                $row['afbeelding'],
                $row['prijs']
            );
        } else {
            return null;
        }
    }

    /**
     * Zoek albums op basis van artiesten.
     *
     * @param PDO $db De PDO-databaseverbinding.
     * @param string $artiesten De artiest(en) om op te zoeken.
     * @return Album[] Een array van Album objecten die aan de zoekcriteria voldoen.
     */
    public static function findByArtiesten(PDO $db, string $artiesten): array
    {
        // Zet de artiesten eerst om naar lowercase letters
        $artiesten = strtolower($artiesten);

        // Voorbereiden van de query
        $stmt = $db->prepare("SELECT * FROM Album WHERE LOWER(artiesten) LIKE :artiesten");

        // Voeg wildcard toe aan de artiesten
        $artiesten = "%$artiesten%";

        // Bind de artiesten aan de query en voer deze uit
        $stmt->bindParam(':artiesten', $artiesten);
        $stmt->execute();

        // Array om albums op te slaan
        $albums = [];

        // Itereren over de resultaten en albums toevoegen aan de array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $albums[] = new Album(
                $row['ID'],
                $row['naam'],
                $row['artiesten'],
                $row['releaseDatum'],
                $row['URL'],
                $row['afbeelding'],
                $row['prijs']
            );
        }

        // Retourneer array met albums
        return $albums;
    }

    /**
     * Sla een nieuw album op in de database.
     *
     * @param PDO $db De PDO-databaseverbinding.
     */
    public function save(PDO $db): void
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("INSERT INTO Album (naam, artiesten, release_datum,URL, afbeelding, prijs) VALUES (:naam, :artiesten, :releaseDatum, :URL, :afbeelding, :prijs)");
        $stmt->bindParam(':naam', $this->naam);
        $stmt->bindParam(':artiesten', $this->artiesten);
        $stmt->bindParam(':releaseDatum', $this->releaseDatum);
        $stmt->bindParam(':URL', $this->URL);
        $stmt->bindParam(':afbeelding', $this->afbeelding);
        $stmt->bindParam(':prijs', $this->prijs);
        $stmt->execute();
    }

    /**
     * Werk een bestaand album bij in de database.
     *
     * @param PDO $db De PDO-databaseverbinding.
     */
    public function update(PDO $db): void
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("UPDATE Album SET naam = :naam, artiesten = :artiesten, release_datum= :releaseDatum, URL = :URL, afbeelding = :afbeelding, prijs = :prijs WHERE ID = :ID");
        $stmt->bindParam(':ID', $this->ID);
        $stmt->bindParam(':naam', $this->naam);
        $stmt->bindParam(':artiesten', $this->artiesten);
        $stmt->bindParam(':releaseDatum', $this->releaseDatum);
        $stmt->bindParam(':URL', $this->URL);
        $stmt->bindParam(':afbeelding', $this->afbeelding);
        $stmt->bindParam(':prijs', $this->prijs);
        $stmt->execute();
    }

    // Getters
    public function getID(): ?int
    {
        return $this->ID;
    }

    public function getNaam(): string
    {
        return $this->naam;
    }

    public function getArtiesten(): string
    {
        return $this->artiesten;
    }

    public function getReleaseDatum(): string
    {
        return $this->release_datum;
    }

    public function getURL(): string
    {
        return $this->URL;
    }

    public function getAfbeelding(): string
    {
        return $this->afbeelding;
    }

    public function getPrijs(): float
    {
        return $this->prijs;
    }

    // Setters
    public function setNaam(string $naam): void
    {
        $this->naam = $naam;
    }

    public function setArtiesten(string $artiesten): void
    {
        $this->artiesten = $artiesten;
    }

    public function setReleaseDatum(string $releaseDatum): void
    {
        $this->releaseDatum = $releaseDatum;
    }

    public function setURL(string $URL): void
    {
        $this->URL = $URL;
    }

    public function setAfbeelding(string $afbeelding): void
    {
        $this->afbeelding = $afbeelding;
    }

    public function setPrijs(float $prijs): void
    {
        $this->prijs = $prijs;
    }
}
