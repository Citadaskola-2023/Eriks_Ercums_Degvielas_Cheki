<?php

namespace App;
class FuelReceiptRequest
{
    private const string url = 'receipt?';
    private const columnNames = [
            'id' => 'ID',
            'licence_plate' => 'Licence Plate',
            'date_time' => 'Date and time',
            'petrol_station' => 'Petrol station',
            'fuel_type' => 'Fuel type',
            'refueled' => 'Refueled',
            'total' => 'Total',
            'currency' => 'Currency',
            'fuel_price' => 'Fuel price',
            'odometer' => 'Odometer',
        ];
    private const orderBy = [
            'id' => 'SELECT * FROM Form ORDER BY id',
            'licence_plate' => 'SELECT * FROM Form ORDER BY licence_plate',
            'date_time' => 'SELECT * FROM Form ORDER BY date_time',
            'petrol_station' => 'SELECT * FROM Form ORDER BY petrol_station',
            'fuel_type' => 'SELECT * FROM Form ORDER BY fuel_type',
            'refueled' => 'SELECT * FROM Form ORDER BY refueled',
            'total' => 'SELECT * FROM Form ORDER BY total',
            'currency' => 'SELECT * FROM Form ORDER BY currency',
            'fuel_price' => 'SELECT * FROM Form ORDER BY fuel_price',
            'odometer' => 'SELECT * FROM Form ORDER BY odometer',
        ];
    private string $lastQurey = ' ';
    public function requestData(string $query = 'SELECT * FROM Form') : void{
        if($this->lastQuery == $query){
            $query = parse_url($_SERVER['REQUEST_URI'])['query'];
        }
        else{
            $this->lastQurey = $query;
        }
        echo "<h3> " . $query;
        $db = new DB();
        $conn = $db->connectDB();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();


        if (!empty($results)) {
            echo '<table>';
            echo '<tr>';
            foreach ($results[0] as $key => $value) {
                if(array_key_exists($key, self::columnNames)){

                    echo '<th>' . '<a href="' . self::url . self::orderBy[$key] . '">' . self::columnNames[$key] . '</a>'. '</th>';
                }
                else{
                    echo '<th>' . htmlspecialchars($key) . '</th>';
                }
            }
            echo '</tr>';


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