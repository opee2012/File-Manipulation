<!DOCTYPE html>
<HTML lang="en">
<HEAD>
    <TITLE>Modify Companies</TITLE>
</HEAD>
<BODY>
<?php

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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    ?>
    <H3>Modify Entry</H3>
    <FORM method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
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
        </TABLE>
    <?php
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rem_sel = $_POST["rem_comp"];
    if ($rem_sel < count($csv)) {
        unset($csv[$rem_sel]);
        $openFile = fopen("../callList.csv", "w");

        foreach ($csv as $line) {
            fputcsv($openFile, $line);
        }

        fclose($openFile);
        header("Location: ../admin.php");
    }
}
?>

    <TABLE name="test">
        <tr>
            <td><LABEL for="add_comp">Company Name:</LABEL></td>
            <td><INPUT type="text" id="add_comp" name="comp_name" value="<?php echo $csv[$rem_sel][0];?>"></td>
            <td><SPAN class="error">* <?php echo $nameErr;?></SPAN></td>
        </tr>
        <tr>
            <td><LABEL for="add_phone">Company Phone:</LABEL></td>
            <td><INPUT type="text" id="add_phone" name="phone_num" value="<?php echo $csv[$rem_sel][1];?>"></td>
            <td><SPAN class="error" style=>* <?php echo $numberErr;?></SPAN></td>
            <td
        </tr>
    </TABLE>
    <INPUT type="submit" value="Submit">
    <INPUT type="reset" value="Reset">
</FORM>
</BODY>
</HTML>