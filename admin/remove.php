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
<!DOCTYPE html>
<HTML lang="en">
<HEAD>
    <TITLE>Remove Companies</TITLE>
</HEAD>
<BODY>
    <H3>Remove Entry</H3>
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
        </TABLE>
        <input type="submit" value="Submit">
    </FORM>
</BODY>
        </HTML>
    <?php
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        $rem_sel = $_POST["rem_comp"];
        $company = $csv[$rem_sel][0];
        if ($rem_sel < count($csv)) {
            unset($csv[$rem_sel]);
            $openFile = fopen("../callList.csv", "w");

            foreach ($csv as $line) {
                fputcsv($openFile, $line);
            }

            fclose($openFile);
            header("Location: ../admin.php");
        }

        $confirmation = ($company . " removed from call list.");
        header("Location: ../admin.php?confirmation=$confirmation");
    }
    ?>