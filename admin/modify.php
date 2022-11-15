<?php
$comp_name = $phone_num = "";
$nameErr = $numberErr = "";

function csvToArray(): array
{
    $file = fopen("../callList.csv", 'r');
    while (!feof($file)) {
        $lines[] = fgetcsv($file, 1000);
    }
    fclose($file);
    return $lines;
}
$csv = csvToArray();

function test_input($data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    ?>
<!DOCTYPE html>
<HTML lang="en">
<HEAD>
    <TITLE>Modify Companies</TITLE>
    <STYLE>.error {color: red; font-style: italic}</STYLE>
</HEAD>
<BODY>
    <H3>Modify Entry</H3>
    <FORM method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <TABLE>
            <TR>
                <TD><LABEL for="rem_comp">Choose a company:</LABEL></TD>
                <TD>
                    <SELECT id="rem_comp" name="rem_comp">
                        <?php

                        for ($i = 0; $i < count($csv)-1; $i++) {
                            $option = $csv[$i][0];
                            echo "<option value=$i>$option</option>";
                        }
                        ?>
                    </SELECT>
                </TD>
            </TR>
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
<?php
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mod_sel = $_POST["rem_comp"];

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
    if ($error == 0) {
        $csv[$mod_sel] = $add_comp;
        $openFile = fopen("../callList.csv", "w");

        foreach ($csv as $line) {
            fputcsv($openFile, $line);
        }

        fclose($openFile);
        header("Location: ../admin.php");
    }
}
?>

