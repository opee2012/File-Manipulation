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
    <link rel="icon" type="image/x-icon" href="https://lh3.googleusercontent.com/0LbGsNeNgpBHAIXuT8FZ-tDWBHkSb8ratEbbAVXz9I4MdocSF8Rdp2Yu5h89OHPPu6c">
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