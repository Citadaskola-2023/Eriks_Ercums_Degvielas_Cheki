<?php

namespace App;

require __DIR__ . '/../src/DB.php';

class FuelReceiptRequest
{
    public string $idInputMin;
    public string $idInputMax;
    public string $licencePlateInput;
    public string $dateTimeInputMin;
    public string $dateTimeInputMax;
    public string $petrolStationInput;
    public string $fuelTypeInput;
    public string $refueledInputMin;
    public string $refueledInputMax;
    public string $totalInputMin;
    public string $totalInputMax;
    public string $currencyInput;
    public string $fuelPriceInputMin;
    public string $fuelPriceInputMax;
    public string $odometerInputMin;
    public string $odometerInputMax;

    private const array bannedWords = ['DROP', 'INSERT'];

    public function getSearchInputs(): void
    {
        $this->idInputMin = $_POST['idInputMin'];
        $this->idInputMax = $_POST['idInputMax'];
        $this->licencePlateInput = $_POST['licencePlateInput'];
        $this->dateTimeInputMin = $_POST['dateTimeInputMin'];
        $this->dateTimeInputMax = $_POST['dateTimeInputMax'];
        $this->petrolStationInput = $_POST['petrolStationInput'];
        $this->fuelTypeInput = $_POST['fuelTypeInput'];
        $this->refueledInputMin = $_POST['refueledInputMin'];
        $this->refueledInputMax = $_POST['refueledInputMax'];
        $this->totalInputMin = $_POST['totalInputMin'];
        $this->totalInputMax = $_POST['totalInputMax'];
        $this->currencyInput = $_POST['currencyInput'];
        $this->fuelPriceInputMin = $_POST['fuelPriceInputMin'];
        $this->fuelPriceInputMax = $_POST['fuelPriceInputMax'];
        $this->odometerInputMin = $_POST['odometerInputMin'];
        $this->odometerInputMax = $_POST['odometerInputMax'];

        $sqlQuery = 'SELECT * FROM Form WHERE 1=1';
        //id
        //id
        if (!empty($this->idInputMin)) {
            $sqlQuery .= ' AND id >= ' . $this->idInputMin;
        }
        if (!empty($this->idInputMax)) {
            $sqlQuery .= ' AND id <= ' . $this->idInputMax;
        }
        //licence plate
        if (!empty($this->licencePlateInput)) {
            $sqlQuery .= ' AND licence_plate = "' . $this->licencePlateInput . '"';
        }
        // date time
        if (!empty($this->dateTimeInputMin)) {
            $sqlQuery .= ' AND date_time >= "' . $this->dateTimeInputMin . '"';
        }
        if (!empty($this->dateTimeInputMax)) {
            $sqlQuery .= ' AND date_time <= "' . $this->dateTimeInputMax . '"';
        }
        // petrol station
        if (!empty($this->petrolStationInput)) {
            $sqlQuery .= ' AND petrol_station = "' . $this->petrolStationInput . '"';
        }
        // fuel type
        if (!empty($this->fuelTypeInput)) {
            $sqlQuery .= ' AND fuel_type = "' . $this->fuelTypeInput . '"';
        }
        // refueled
        if (!empty($this->refueledInputMin)) {
            $sqlQuery .= ' AND refueled >= ' . $this->refueledInputMin;
        }
        if (!empty($this->refueledInputMax)) {
            $sqlQuery .= ' AND refueled <= ' . $this->refueledInputMax;
        }
        // total
        if (!empty($this->totalInputMin)) {
            $sqlQuery .= ' AND total >= ' . $this->totalInputMin;
        }
        if (!empty($this->totalInputMax)) {
            $sqlQuery .= ' AND total <= ' . $this->totalInputMax;
        }
        // currency
        if (!empty($this->currencyInput)) {
            $sqlQuery .= ' AND currency = "' . $this->currencyInput . '"';
        }
        // fuel price
        if (!empty($this->fuelPriceInputMin)) {
            $sqlQuery .= ' AND fuel_price >= ' . $this->fuelPriceInputMin;
        }
        if (!empty($this->fuelPriceInputMax)) {
            $sqlQuery .= ' AND fuel_price <= ' . $this->fuelPriceInputMax;
        }
        // odometer
        if (!empty($this->odometerInputMin)) {
            $sqlQuery .= ' AND odometer >= ' . $this->odometerInputMin;
        }
        if (!empty($this->odometerInputMax)) {
            $sqlQuery .= ' AND odometer <= ' . $this->odometerInputMax;
        }

        $_POST['sortBy'] = 'refueled';
        $_POST['sortDirection'] = 'ASC';
        // ORDER BY {} ASC/DESC

        $this->displayData($sqlQuery);
    }

    public function requestData(): void
    {
        //check
        $query = parse_url($_SERVER['REQUEST_URI'])['query'];
        $query = urldecode($query);
        if (empty($query)) {
            $query = 'SELECT * FROM Form';
        }
        echo "<h3> " . $query;

        //ASC or DESC
        $dom = new \DOMDocument();
        $dom->loadHTMLFile('../html/data.html');
        $anchors = $dom->getElementsByTagName('a');

        foreach ($anchors as $anchor) {
            $href = $anchor->getAttribute('href');
            $modifiedHref = '';
            if (stripos($href, 'ASC')) {
                $modifiedHref = str_replace("ASC", "DESC", $href);
            } else {
                if (stripos($href, 'DESC')) {
                    $modifiedHref = str_replace("DESC", "ASC", $href);
                }
            }
            $anchor->setAttribute('href', $modifiedHref);
        }

        file_put_contents('../html/data.html', $dom->saveHTML());


        foreach (self::bannedWords as $bw) {
            if (stristr($query, $bw)) {
                echo "<script>window.location.replace('/')</script>";
                exit;
            }
        }

        $this->displayData($query);
    }

    private function displayData(string $query): void
    {
        foreach (self::bannedWords as $bw) {
            if (stristr($query, $bw)) {
                echo "<script>window.location.replace('/')</script>";
                exit;
            }
        }

        //connection
        $db = new DB();
        $conn = $db->connectDB();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();
        echo "<h4>" . var_dump($results) . "</h4>";
        echo "<h4>" . var_dump($stmt) . "</h4>";

        //dataTable
        //get dataTable div
        $dom = new \DOMDocument();
        $dom->loadHTMLFile('../html/data.html');
        $dataTable = $dom->getElementById('dataTable');

        if ($dataTable->hasChildNodes()) {
            while ($dataTable->hasChildNodes()) {
                $dataTable->removeChild($dataTable->firstChild);
            }
        }

        //add data
        if (!empty($results)) {
            $table = $dom->createElement('table');
            foreach ($results as $row) {
                $tr = $dom->createElement('tr');
                foreach ($row as $value) {
                    $td = $dom->createElement('td', htmlspecialchars($value));
                    $tr->appendChild($td);
                }
                $table->appendChild($tr);
            }
            $dataTable->appendChild($table);
        } else {
            echo 'Sudi...';
        }

        file_put_contents('../html/data.html', $dom->saveHTML());
        echo "<script>window.location.replace('/data?')</script>";
        exit;
    }
}