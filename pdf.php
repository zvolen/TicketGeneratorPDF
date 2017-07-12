<?php

//require_once "includes/form.php";
require_once "includes/airports.php";
require_once "vendor/autoload.php"; // composer loader

$faker = Faker\Factory::create(); //create a Faker\Generator instance

use NumberToWords\NumberToWords;
$numberToWords = new NumberToWords(); // create the number to words "manager" class
$currencyTransformer = $numberToWords->getCurrencyTransformer('en'); // build a new currency transformer using the RFC 3066 language identifier

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if ($_POST['departure'] !== $_POST['arrival']) {
        if (!empty($_POST['date']) && !empty($_POST['flight-time'])) {
            if ($_POST['cost'] > 0) {

                $departure = $airports[$_POST['departure']];
                $arrival = $airports[$_POST['arrival']];
                $date = $_POST['date'];
                $flightTime = $_POST['flight-time'];
                $price = $_POST['cost'];
                $arriveTimezone = $arrival['timezone'];
                $departureTimezone = $departure['timezone'];

                $departureDate = new DateTime($date, new DateTimeZone($departureTimezone));
                $departureDate = $departureDate->format('d.m.Y H:i:s');

                $arrivalDate = new DateTime($date, new DateTimeZone($arriveTimezone));
                $arrivalDate = $arrivalDate->modify('+' . $flightTime . 'minutes');
                $arrivalDate = $arrivalDate->format('d.m.Y H:i:s');

                $table ="<table>
                            <tr>
                                <th>Airport departure:</th>
                                <th>Time of departure:</th>
                                <th>Airport code:</th>
                            </tr>
                            <tr>
                                <td>" . $departure['name'] . "</td>
                                <td>" . $departureDate . "</td>
                                <td>" . $departure['code'] . "</td>
                            </tr>
                            
                            <tr>
                                <th>Arrival airport:</th>
                                <th>Arrival time:</th>
                                <th>Airport code:</th>
                            </tr>
                            <tr>
                                <td>" . $arrival['name'] . "</td>
                                <td>" . $arrivalDate . "</td>
                                <td>" . $arrival['code'] . "</td>
                            </tr>
                            <tr>
                                <th>Flight time:</th>    
                                <th>Price in USD:</th>
                            </tr>
                            <tr>
                                <td>" . $flightTime . "</td>
                                <td>" . $price . "</td>
                            </tr>
                        </table>
                    
                        <table>
                            <tr>
                                <th>Passenger:</th>
                                <th>Address:</th>
                            </tr>
                            <tr>
                                <td>" . $faker->name . "</td>
                                <td>" . $faker->address . "</td>
                            </tr>
                        </table>
                    
                        <table>
                            <tr>
                                <th>Price:</th>
                            </tr>
                            <tr>
                                <td>" . $currencyTransformer->toWords($price * 100, 'USD') . "</td>
                            </tr>
                        </table>";

                $mpdf = new mPDF('utf-8', 'A4');
                $mpdf->WriteHTML($table);
                $mpdf->Output('ticket.pdf', 'D');

            } else {
                echo "Error. Bad value flight price.";
            }
        } else {
            echo "Please select the date and time of the flight";
        }
    } else {
        echo "Departure and arrival airport can not be the same";
    }
}
require_once 'includes/form.php';