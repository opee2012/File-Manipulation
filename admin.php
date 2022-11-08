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
            $comp_name = test_input($_POST["comp_name"]);
            $error = 0;
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$comp_name)) {
                $nameErr = "Only letters and whitespace allowed";
                $error = 1;
            }

            $phone_num = test_input($_POST["phone_num"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/1-[0-9]{3}-[0-9]{3}-[0-9]{4}/",$phone_num)) {
                $numberErr = "Incorrect format ex. 1-###-###-####";
                $error = 1;
            }
        }
        ?>
    <h2>Add, Remove, Modify Admin Page</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        
    <h3>Add Entry</h3>
        <TABLE>
            <tr>
                <td><LABEL for="add_comp">Company Name:</LABEL></td>
                <td><INPUT type="text" id="add_comp" name="comp_name" value="<?php echo $comp_name;?>"></td>
                <td><SPAN style="color: red;font-style: italic"><?php echo $nameErr;?></SPAN></td>
            </tr>
            <tr>
                <td><LABEL for="add_phone">Company Phone:</LABEL></td>
                <td><INPUT type="text" id="add_phone" name="phone_num" value="<?php echo $phone_num;?>"></td>
                <td><SPAN style="color: red;font-style: italic"><?php echo $numberErr;?></SPAN></td>
            </tr>
        </TABLE>
        <INPUT type="reset" value="Reset">
        <INPUT type="submit" value="Submit">
        <br><br>
        <?php
        // sanitize the var $_POST['name'] with a basic filter
        $A = array(
            filter_input(INPUT_POST, 'comp_name'),
            filter_input(INPUT_POST, 'phone_num')
        );

        if ($A[0] != '' && $A[1] != '' && $error == 0) {
            $openFile = fopen('callList.csv', 'a+');

            // append the sanitized input to our text file
            $fp = fwrite($openFile, implode(',', $A). "\r\n");

            fclose($openFile);
        }
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