<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Companies</title>
    </head>
    <body>
        <table>
        <?php
        $comp_name = $phone_num = "";
        $nameErr = $numberErr = "";

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            return htmlspecialchars($data);
        }

        function csvToArray() {
            $file = fopen("callList.csv", 'r');
            while (!feof($file)) {
                $lines[] = fgetcsv($file, 1000, ',');
            }
            fclose($file);
            return $lines;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $comp_name = test_input($_POST["name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$comp_name)) {
                $nameErr = "Only letters and whitespace allowed";
            }

            $phone_num = test_input($_POST["phone"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/1-[0-9]{3}-[0-9]{3}-[0-9]{4}/",$phone_num)) {
                $numberErr = "Incorrect format ex. 1-###-###-####";
            }
        }
        ?>
    <h2>Add, Remove, Modify Admin Page</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        
    <h3>Add Entry</h3>
    Company Name:
        <label>
            <input type="text" name="name" value="<?php echo $comp_name;?>">
        </label>
        <span class="error"><?php echo $nameErr;?></span><br>
    Company Phone:
        <label>
            <input type="text" name="phone" value="<?php echo $phone_num;?>">
        </label>
        <span class="error"><?php echo $numberErr;?></span><br>
    <input type="submit" name="submit" value="Submit"><br>
        <?php
        $list = array ($comp_name, $phone_num);
        $file = fopen("callList.csv", "a");
        fputcsv($file, $list);
        fclose($file);
        ?>
    <h3>Remove Entry</h3>
        <?php
        $file = fopen("callList.csv", "a");
        $csv = csvToArray();
        ?>
        <label for="companies">Choose a company: </label>
        <select id="companies">
            <?php
            for ($i = 1; $i <= count($csv); $i++){
                $option = $csv[$i-1][0];
                echo "<option value='$i'>$option</option>";
            }
            ?>
        </select>
        <?php

        ?>
    Modify Entry<br>
        </table>
    </body>
</html>



HTML Forms

if submit was add, rem, or mod, do that action 