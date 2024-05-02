<?php

namespace App;

require __DIR__ . '/../src/DB.php';

class FuelReceiptRequest
{
    private const string url = 'receipt?';

    private const columns = [
        'ID',
        'Licence Plate',
        'Date and time',
        'Petrol station',
        'Fuel type',
        'Refueled',
        'Total',
        'Currency',
        'Fuel price',
        'Odometer'
    ];
    private string $ascendingOrder = 'ASC';
    private const orderBy = [
        'ID' => 'SELECT * FROM Form ORDER BY id',
        'Licence Plate' => 'SELECT * FROM Form ORDER BY licence_plate',
        'Date and time' => 'SELECT * FROM Form ORDER BY date_time',
        'Petrol station' => 'SELECT * FROM Form ORDER BY petrol_station',
        'Fuel type' => 'SELECT * FROM Form ORDER BY fuel_type',
        'Refueled' => 'SELECT * FROM Form ORDER BY refueled',
        'Total' => 'SELECT * FROM Form ORDER BY total',
        'Currency' => 'SELECT * FROM Form ORDER BY currency',
        'Fuel price' => 'SELECT * FROM Form ORDER BY fuel_price',
        'Odometer' => 'SELECT * FROM Form ORDER BY odometer',
    ];

    public string $idInput;
    public string $licencePlateInput;
    public string $dateTimeInput;
    public string $petrolStationInput;
    public string $fuelTypeInput;
    public string $refueledInput;
    public string $totalInput;
    public string $currencyInput;
    public string $fuelPriceInput;
    public string $odometerInput;

    public function getSearchInputs(): void
    {
        $this->idInput = $_POST['idInput'];
        $this->licencePlateInput = $_POST['licencePlateInput'];
        $this->dateTimeInput = $_POST['dateTimeInput'];
        $this->petrolStationInput = $_POST['petrolStationInput'];
        $this->fuelTypeInput = $_POST['fuelTypeInput'];
        $this->refueledInput = $_POST['refueledInput'];
        $this->totalInput = $_POST['totalInput'];
        $this->currencyInput = $_POST['currencyInput'];
        $this->fuelPriceInput = $_POST['fuelPriceInput'];
        $this->odometerInput = $_POST['odometerInput'];
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
        $dom->loadHTMLFile('../html/receiptData.html');
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

        file_put_contents('../html/receiptData.html', $dom->saveHTML());

        //connection
        $db = new DB();
        $conn = $db->connectDB();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();

        //search
        /*echo '<table>';
        echo '<tr>';
        foreach (self::columns as $column) {
            echo '<th>' . '<a href="' . self::url . self::orderBy[$column] . ' ' . $this->ascendingOrder . '">' . $column . '</a>' . '</th>';
        }
        echo '</tr>';

        echo '</table>';

        if($query != 'SELECT * FROM Form' && !empty($query)){
            //find column
            $searchBy = '';

            if(strpos($query, "ASC") || strpos($query, "DESC")){
                $pos = strpos($query, 'ORDER BY');
                if(!empty($pos)){
                    $substring = substr($query, $pos + strlen("ORDER BY"));

                    $asc_pos = strpos($substring, 'ASC');
                    $desc_pos = strpos($substring, 'DESC');

                    if(!empty($asc_pos)){
                        $searchBy = trim(substr($substring, 0, $asc_pos));
                    }
                    else{
                        $searchBy = trim(substr($substring, 0, $desc_pos));
                    }
                }
            }
            else{
                $searchBy = substr(strrchr($query, ' '), 1);
            }
            echo $searchBy . ': <input type="text">';
        }*/

        //data table
        if (!empty($results)) {
            echo '<table>';
            foreach ($results as $row) {
                echo '<tr>';
                foreach ($row as $value) {
                    echo '<td>' . htmlspecialchars($value) . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No results found.';
        }
    }
}