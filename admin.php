<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Companies</title>
    </head>
    <body>
        <?php
        $comp_name = $phone_num = "";
        $nameErr = $numberErr = "";

        function test_input($data): string
        {
            $data = trim($data);
            $data = stripslashes($data);
            return htmlspecialchars($data);
        }

        function csvToArray(): array
        {
            $file = fopen("callList.csv", 'r');
            $j = 0;
            while (!feof($file)) {
                $lines[] = fgetcsv($file, 1000, ',');
            }
            fclose($file);
            return $lines;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $comp_name = test_input($_POST["comp_name"]);
            $phone_num = test_input($_POST["phone_num"]);
            $error = 0;

            if (empty($comp_name) && empty($phone_num)) {
                $error = 1;
            } else {
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-' ]*$/",$comp_name)) {
                    $nameErr = "Only letters and whitespace allowed";
                    $error = 1;
                }
                // check if name only contains letters and whitespace
                if (!preg_match("/1-[0-9]{3}-[0-9]{3}-[0-9]{4}/",$phone_num)) {
                    $numberErr = "Incorrect format ex. 1-###-###-####";
                    $error = 1;
                }
            }
        }
        ?>
    <h2>Add, Remove, Modify Admin Page</h2>
    <FORM method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
        
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
        <INPUT type="submit" value="Submit">
        <INPUT type="reset" value="Reset">
    </FORM>
        <?php
        // sanitize the var $_POST['name'] with a basic filter
        $add_comp = array(
            filter_input(INPUT_POST, 'comp_name'),
            filter_input(INPUT_POST, 'phone_num')
        );

        if ($add_comp[0] != '' && $add_comp[1] != '' && $error == 0) {
            $openFile = fopen('callList.csv', 'a');

            // append the sanitized input to our text file
            fwrite($openFile, implode(',', $add_comp). "\r\n");

            fclose($openFile);
        }
        ?>
    <br><br>
    <FORM method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" >

    <h3>Remove Entry</h3>
        <TABLE>
            <tr>
                <td><LABEL for="rem_comp">Choose a company:</LABEL></td>
                <td>
                <SELECT id="rem_comp" name="rem_comp">
                    <?php
                    $openFile = fopen("callList.csv", "a");
                    $csv = csvToArray();

                    for ($i = 0; $i < count($csv)-1; $i++) {
                        $option = $csv[$i][0];
                        echo "<option value=".$i.">".$option."</option>";
                    }
                    fclose($openFile);

                    echo "<option name='rem_comp[$i]'></option>"
                    ?>
                    </SELECT>
                </td>
            </tr>
        </TABLE>
        <INPUT type="submit" name="submit" value="Submit">
    </FORM>
        <?php
        $selected = $_POST['rem_comp'];

        unset($csv[$selected]);
        $openFile = fopen("callList.csv", "w");

        foreach ($csv as $fields) {
            fputcsv($openFile, $fields);
        }
        fclose($openFile);
        ?>
    <br>
    <FORM method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">

    <H3>Modify Entry</H3>
    </FORM>
    </body>
</html>