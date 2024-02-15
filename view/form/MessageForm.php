<!-- We stored information and errors inside $_SESSION["info"] (array) and $_SESSION["error"] (array) -->
<!-- Here, we show those values in two separate divs -->

<div id="info">
<?php
if (isset($_SESSION["info"]))
{
    foreach ($_SESSION["info"] as $key => $value)
    {
        echo "<p>$value</p>";
    }
}
$_SESSION["info"] = null;
?>
</div>

<div id="error">
<?php
if (isset($_SESSION["error"]))
{
    foreach ($_SESSION["error"] as $key => $value)
    {
        echo "<p>$value</p>";
    }
}
$_SESSION["error"] = null;
?>
</div>