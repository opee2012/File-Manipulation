<?php
    $comp_name = $phone_num = "";
    $nameErr = $numberErr = "";

    function test_input($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $comp_name = test_input($_POST['comp_name']);
        $phone_num = test_input($_POST['phone_num']);
        $error = 0;

        $add_comp = array($comp_name, $phone_num);

        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $comp_name) || empty($comp_name)) {
            if (empty($comp_name)) $nameErr = "Company name is required";
            else $nameErr = "Only letters and whitespace allowed";
            $error = 1;
        }
        // check if name only contains letters and whitespace
        if (!preg_match("/1-[0-9]{3}-[0-9]{3}-[0-9]{4}/", $phone_num) || empty($phone_num)) {
            if (empty($phone_num)) $numberErr = "Company phone number is required";
            else $numberErr = "Incorrect format ex. 1-###-###-####";
            $error = 1;
        }
        if ($error == 1) {
            $name_error = urlencode($nameErr);
            $num_error = urlencode($numberErr);
            header("Location: add.php?nameErr=$name_error&numberErr=$num_error");
        }
        if ($error == 0) {
            $openFile = fopen('../callList.csv', 'a');

            // append the sanitized input to our text file
            fwrite($openFile, implode(',', $add_comp) . "\r\n");

            fclose($openFile);

            $confirmation = ($comp_name . " added to call list.");
            header("Location: ../admin.php?confirmation=$confirmation");
        }
    } else {
    ?>
    <!DOCTYPE html>
    <HTML lang="en">
    <HEAD>
        <title>Add Companies</title>
        <STYLE>.error {color: red; font-style: italic}</STYLE>
    </HEAD>
    <BODY>
    <H3>Add Entry</H3>
    <FORM method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <TABLE>
            <tr>
                <td><LABEL for="add_comp">Company Name:</LABEL></td>
                <td><INPUT type="text" id="add_comp" name="comp_name"></td>
                <td><SPAN class="error">* <?php echo $_GET['nameErr'];?></SPAN></td>
            </tr>
            <tr>
                <td><LABEL for="add_phone">Company Phone:</LABEL></td>
                <td><INPUT type="text" id="add_phone" name="phone_num"></td>
                <td><SPAN class="error">* <?php echo $_GET['numberErr'];?></SPAN></td>
                <td
            </tr>
        </TABLE>
        <INPUT type="submit" value="Submit">
        <INPUT type="reset" value="Reset">
    </FORM>
    </BODY>
</HTML>

<?php
    }
?>
