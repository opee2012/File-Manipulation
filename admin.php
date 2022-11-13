<!DOCTYPE html>
<HTML lang="en">
    <HEAD>
        <title>Companies Admin Page</title>
    </HEAD>
    <BODY>
    <H2>Add, Remove, Modify Admin Page</H2>
    <FORM method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <TABLE>
        <TR>
            <TD><INPUT type="radio" id="add" name="rb" value="1"></TD>
            <TD><LABEL for="add">Add Company</LABEL></TD>
        </TR>
        <TR>
            <TD><INPUT type="radio" id="remove" name="rb" value="2"></TD>
            <TD><LABEL for="remove">Remove Company</LABEL></TD>
        </TR>
        <TR>
            <TD><INPUT type="radio" id="modify" name="rb" value="3"></TD>
            <TD><LABEL for="modify">Modify Company</LABEL></TD>
        </TR>
    </TABLE>
    <INPUT type="submit" value="Submit">
    </FORM>
    <?php
    $rb = $_POST['rb'];

    switch ($rb) {
        case 1:
            header("Location: admin/add.php");
            break;
        case 2:
            header("Location: admin/remove.php");
            break;
        case 3:
            header("Location: admin/modify.php");
            break;
    }
    ?>
    <BR>
    <a href="index.php">Back to homepage</a>
    </BODY>
</HTML>