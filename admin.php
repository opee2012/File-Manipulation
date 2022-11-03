<!DOCTYPE html>
<html>
    <head>
        <title>Companies</title>
    </head>
    <body>
        <table>
        <?php
        $comp_name = $phone_num = "";
        $nameErr = $numberErr = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $comp_name = test_input($_POST["name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$comp_name)) {
                $nameErr = "Only letters and whitespace allowed";
            }

            $phone_num = test_input($_POST["phone"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/[1]{1}-[0-9]{3}-[0-9]{3}-[0-9]{4}/",$phone_num)) {
                $numberErr = "Only letters and whitespace allowed";
            }
        }
        ?>
    <h2>Add, Remove, Modify Admin Page</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        
    <h3>Add Entry</h3>
    Company Name: 
    <input type="text" name="name" value="<?php echo $comp_name;?>">
    <span class="error"><?php echo $nameErr;?></span><br>
    Company Phone:
    <input type="text" name="phone" value="<?php echo $phone_num;?>">
    <span class="error"><?php echo $numberErr;?></span><br>
    <input type="submit" name="submit" value="Submit"><br>
    <?php
    $list = array ($comp_name, $phone_num);
    $file = fopen("callList.csv", "a");
    fputcsv($file, $list);
    fclose($file);
    ?>
    <h3>Remove Entry</h3>
    Modify Entry<br>
        </table>
    </body>
</html>