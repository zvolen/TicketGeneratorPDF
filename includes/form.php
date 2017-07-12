<?php
    require_once "airports.php";
?>

<div class="form-group">
    <form action="pdf.php" method="POST">
        <label>Departure:
            <select name="departure">
                <?php
                    $cnt = count($airports);
                    for ($i = 0; $i < $cnt; $i++) {
                        echo "<option value='$i'>" . $airports[$i]['name'] . "</option>";
                    }
                ?>
            </select>
        </label>
        <label>Arrival:
            <select name="arrival">
                <?php
                    $cnt = count($airports);
                    for ($i = 0; $i < $cnt; $i++) {
                        echo "<option value='$i'>" . $airports[$i]['name'] . "</option>";
                    }
                ?>
            </select>
        </label>
        <label>Time:
            <input name="date" id="datetime" type="datetime-local">
        </label>
        <label>Flight time:
            <input name="flight-time" type="number" min="0" step="1">
        </label>
        <label>Cost:
            <input name="cost" type="number" min="0" step="0.1">
        </label>
        <button type="submit" value="submit">Submit</button>
    </form>
</div>