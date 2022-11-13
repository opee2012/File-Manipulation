<!DOCTYPE html>
<HTML lang="en">
    <HEAD>
        <title>Add Companies</title>
        <STYLE>.error {color: red; font-style: italic}</STYLE>
    </HEAD>
    <BODY>
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

        $comp_name = test_input(filter_input(INPUT_POST, 'comp_name'));
        $phone_num = test_input(filter_input(INPUT_POST, 'phone_num'));
        $error = 0;

        $quoted_comp_name = str_replace("%quotes%", $comp_name, "\"%quotes%\"");

        $add_comp = array($quoted_comp_name, $phone_num);

        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $comp_name) || empty($comp_name)) {
            if (empty($_POST['comp_name'])) $nameErr = "Company name is required";
            else $nameErr = "Only letters and whitespace allowed";
            $error = 1;
        }
        // check if name only contains letters and whitespace
        if (!preg_match("/1-[0-9]{3}-[0-9]{3}-[0-9]{4}/", $phone_num) || empty($phone_num)) {
            if (empty($_POST['phone_num'])) $numberErr = "Company phone number is required";
            else $numberErr = "Incorrect format ex. 1-###-###-####";
            $error = 1;
        }
        if ($error == 0) {
            $openFile = fopen('../callList.csv', 'a');

            // append the sanitized input to our text file
            fwrite($openFile, implode(',', $add_comp) . "\r\n");

            fclose($openFile);
            header("Location: ../admin.php");
        }
    }

    ?>
    <H3>Add Entry</H3>
    <FORM method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <TABLE name="test">
            <tr>
                <td><LABEL for="add_comp">Company Name:</LABEL></td>
                <td><INPUT type="text" id="add_comp" name="comp_name"></td>
                <td><SPAN class="error">* <?php echo $nameErr;?></SPAN></td>
            </tr>
            <tr>
                <td><LABEL for="add_phone">Company Phone:</LABEL></td>
                <td><INPUT type="text" id="add_phone" name="phone_num"></td>
                <td><SPAN class="error" style=>* <?php echo $numberErr;?></SPAN></td>
                <td
            </tr>
        </TABLE>
        <INPUT type="submit" value="Submit">
        <INPUT type="reset" value="Reset">
    </FORM>
    </BODY>
</HTML>