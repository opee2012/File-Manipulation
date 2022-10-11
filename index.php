<?php
$callListResouce = fopen("callList.csv", "r");
$companies = array();

if(!is_resource($callListResouce))
{
    echo "Could not open the file";
    exit();
}

while($line = fgets($callListResouce))
{
    $companies[] = explode(",", $line);
}

fclose($callListResouce);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Companies</title>
</head>
<body> 
<h1>Company Listing</h1>
<ul>
<?php
    foreach($companies as $key => $value)
    {
        echo "<li><a href='details.php?company=" . urlencode($key) . "'>" . $value[0] . "</a></li>";
    }
?>
</ul>

    </body>
</html>