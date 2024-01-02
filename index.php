<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="menu_style.css" type="text/css" />
<title>Datenanzeige</title>
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="refresh" content="600" />
<meta http-equiv="expires" content="1" />
<meta name="language" content="de">
<meta name="Title" content= "Datenanzeige">
</head>
<body bgcolor="#000000" text="#FFFFFF" link="#0000FF" vlink="#0000FF" alink="#0000FF">
</body>
<ul class="menu red">
<li class="current"><a href="index.php" target="_self">Datenanzeige</a></li>
</ul>
<br><br>
<font size=6>

<?php
date_default_timezone_set("Europe/Berlin");
$timestamp = time();
$datum = date("d.m.Y", $timestamp);
$uhrzeit = date("H:i:s",$timestamp);
?>
<?php
echo "";
echo $datum," - ",$uhrzeit," Uhr<br />\n";
?>
<?php
$filename = '/dev/shm/temperatur.txt';
if (file_exists($filename))
{
    $inhalt = file_get_contents($filename);
    if (empty($inhalt))
    { echo '<div style="color:#FF0000">'; echo "<br />\nBitte warten sie, bis die Temperatur gemessen wurde {$inhalt}<br /></div>\n"; }
    else
    { echo "<br />\n{$inhalt} ° Celsius<br />\n"; }
}
else
{
    echo '<div style="color:#FF0000">'; echo "Datei $filename gibt es noch gar nicht<br /></div>\n";
}
?>
<?php
$filename = '/dev/shm/luftdruck.txt';
if (file_exists($filename))
{
    $inhalt = file_get_contents($filename);
    if (empty($inhalt))
    { echo '<div style="color:#FF0000">'; echo "<br />Bitte warten sie, bis der Luftdruck gemessen wurde {$inhalt}<br /></div>\n"; }
    else
    { echo "{$inhalt} hPa Luftdruck<br />\n"; }
}
else
{
    echo '<div style="color:#FF0000">'; echo "Datei $filename gibt es noch gar nicht</div>";
}
?>
<?php
$filename = '/dev/shm/luftfeuchtigkeit.txt';
if (file_exists($filename))
{
    $inhalt = file_get_contents($filename);
    if (empty($inhalt))
    { echo '<div style="color:#FF0000">'; echo "<br />\nBitte warten sie, bis die Luftfeuchtigkeit gemessen wurde {$inhalt}<br /></div>\n"; }
    else
    { echo "{$inhalt} % Luftfeuchtigkeit<br />\n"; }
}
else
{
    echo '<div style="color:#FF0000">'; echo "Datei $filename gibt es noch gar nicht</div><br />\n";
}
?>
<br>
<?php
$ch = '12-Volt-Akku';
$filename = '/dev/shm/mcp3208_ch7.txt';
$einschaltspannungsdatei = '/dev/shm/einschaltspannung_ch7_12V.txt';
$ausschaltspannungsdatei = '/dev/shm/ausschaltspannung_ch7_12V.txt';
$einschaltspannung = file_get_contents($einschaltspannungsdatei);
$ausschaltspannung = file_get_contents($ausschaltspannungsdatei);
if (file_exists($filename))
{
    $inhalt = file_get_contents($filename);
    if (empty($inhalt))
    { echo '<div style="color:#FF0000">'; echo "<br />\nBitte warten sie, bis der $ch ausgelesen wurde {$inhalt}<br /></div>\n"; }
    else
      if ($inhalt < 1)
      { echo "Das 12-Volt-System wurde noch nicht angeschlossen<br />\n";}
      else
      if ($inhalt >= $einschaltspannung)
      { echo '<div style="color:#4CFF00">'; echo "Die Spannung am $ch beträgt {$inhalt} Volt, <br />\nmehr als {$einschaltspannung} und mehr als $ausschaltspannung<br /></div>\n"; }
      else
      if ($inhalt >= $ausschaltspannung and $ausschaltspannung <= $einschaltspannung)
    { echo '<div style="color:#F1FF35">'; echo "Die Spannung am $ch beträgt {$inhalt} Volt, <br />\nalso mehr als $ausschaltspannung Volt, aber weniger als $einschaltspannung Volt<br /></div>\n"; }
      else
        if ($inhalt <= $ausschaltspannung)
    { echo '<div style="color:#FF0000">'; echo "Die Spannung am $ch beträgt nur {$inhalt} Volt, <br />\nalso weniger als $einschaltspannung Volt und weniger als $ausschaltspannung Volt<br /></div>\n"; }
}
else
{
    echo '<div style="color:#FF0000">'; echo "Datei $filename gibt es gar nicht<br /></div>\n";
}
?>
<?php
$ch = '24-Volt-Akku';
$filename = '/dev/shm/mcp3208_ch5.txt';
$einschaltspannungsdatei = '/dev/shm/einschaltspannung_ch5_24V.txt';
$ausschaltspannungsdatei = '/dev/shm/ausschaltspannung_ch5_24V.txt';
$einschaltspannung = file_get_contents($einschaltspannungsdatei);
$ausschaltspannung = file_get_contents($ausschaltspannungsdatei);
if (file_exists($filename))
{
    $inhalt = file_get_contents($filename);
    if (empty($inhalt))
    { echo '<div style="color:#FF0000">'; echo "<br />\nBitte warten sie, bis der $ch ausgelesen wurde {$inhalt}<br /></div>\n"; }
    else
      if ($inhalt < 1)
      { echo "Das 24-Volt-System wurde noch nicht angeschlossen<br />\n";}
      else
      if ($inhalt >= $einschaltspannung)
      { echo '<div style="color:#4CFF00">'; echo "Die Spannung am $ch beträgt {$inhalt} Volt, <br />\nmehr als $einschaltspannung und mehr als $ausschaltspannung Volt<br /></div>\n"; }
      else
      if ($inhalt >= $ausschaltspannung and $ausschaltspannung <= $einschaltspannung)
    { echo '<div style="color:#F1FF35">'; echo "Die Spannung am $ch beträgt {$inhalt} Volt, <br />\nalso mehr als $ausschaltspannung Volt, aber weniger als $einschaltspannung Volt<br /></div>\n"; }
      else
        if ($inhalt <= $ausschaltspannung)
    { echo '<div style="color:#FF0000">'; echo "Die Spannung am $ch beträgt nur {$inhalt} Volt, <br />\nalso weniger als $einschaltspannung Volt und weniger als $ausschaltspannung Volt<br /></div>\n"; }
}
else
{
    echo '<div style="color:#FF0000">'; echo "Datei $filename gibt es gar nicht<br /></div>\n";
}
?>
<?php
$ch = '48-Volt-Akku';
$filename = '/dev/shm/mcp3208_ch6.txt';
$einschaltspannungsdatei = '/dev/shm/einschaltspannung_ch6_48V.txt';
$ausschaltspannungsdatei = '/dev/shm/ausschaltspannung_ch6_48V.txt';
$einschaltspannung = file_get_contents($einschaltspannungsdatei);
$ausschaltspannung = file_get_contents($ausschaltspannungsdatei);
if (file_exists($filename))
    {$inhalt = file_get_contents($filename);
    if (empty($inhalt))
    { echo '<div style="color:#FF0000">'; echo "<br />\nBitte warten sie, bis der $ch ausgelesen wurde {$inhalt}<br /></div>\n"; }
    else
      if ($inhalt < 1)
      { echo "Das 48-Volt-System wurde noch nicht angeschlossen<br />\n";}
      else
      if ($inhalt >= $einschaltspannung)
      { echo '<div style="color:#4CFF00">'; echo "Die Spannung am $ch beträgt {$inhalt} Volt, <br />\nmehr als $einschaltspannung und mehr als $ausschaltspannung<br /></div>\n"; }
      else
      if ($inhalt >= $ausschaltspannung and $ausschaltspannung <= $einschaltspannung)
    { echo '<div style="color:#F1FF35">'; echo "Die Spannung am $ch beträgt {$inhalt} Volt, <br />\nalso mehr als $ausschaltspannung Volt, aber weniger als $einschaltspannung Volt<br /></div>\n"; }
      else
        if ($inhalt <= $ausschaltspannung)
    { echo '<div style="color:#FF0000">'; echo "Die Spannung am $ch beträgt nur {$inhalt} Volt, <br />\nalso weniger als $einschaltspannung Volt und weniger als $ausschaltspannung Volt<br /></div>\n"; }
}
else
{
    echo '<div style="color:#FF0000">'; echo "Datei $filename gibt es gar nicht<br /></div>\n";
}
?>
<?php
$relais = '12-Volt-System';
$filename = '/dev/shm/relais1_status.txt';
$anaus = '/media/platte/schuppendaten/strom_an_aus/zerow_an_aus_ch7_12V.txt';
$lines = file($anaus, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if (file_exists($filename))
    {$inhalt = file_get_contents($filename);
    if (empty($inhalt))
        { echo '<div style="color:#FF0000">'; echo "<br />\nBitte warten sie, auf den Status vom $relais $inhalt<br /></div>\n";}
    else
        if (file_exists($anaus))
            $lines = file($anaus, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $lines = array_slice($lines, -4);
        if (is_numeric($inhalt) && ($inhalt == 2))
            {echo "<br />\n$relais ist an, letzte Schaltvorgänge:<br />\n";
            echo implode("<br>", $lines);}
        if (is_numeric($inhalt) && ($inhalt == 1))
            {echo "<br />\n$relais ist aus, letzte Schaltvorgänge:<br />\n";
            echo implode("<br>", $lines);}
}
else
    {echo '<div style="color:#FF0000">'; echo "<br />\nDatei $filename gibt es gar nicht<br /></div>\n";}
?>
<br>
<?php
$relais = '24-Volt-System';
$filename = '/dev/shm/relais3_status.txt';
$anaus = '/media/platte/schuppendaten/strom_an_aus/zerow_an_aus_ch5_24V.txt';
if (file_exists($filename))
    {$inhalt = file_get_contents($filename);
    if (empty($inhalt))
        {echo '<div style="color:#FF0000">'; echo "<br />\nBitte warten sie, auf den Status vom $relais $inhalt<br /></div>\n";}
    else
        if (file_exists($anaus))
            $lines = file($anaus, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $lines = array_slice($lines, -4);
        if (is_numeric($inhalt) && ($inhalt == 2))
            {echo "<br />\n$relais ist an, letzte Schaltvorgänge:<br />\n";
            echo implode("<br>", $lines);}
        if (is_numeric($inhalt) && ($inhalt == 1))
            {echo "<br />\n$relais ist aus, letzte Schaltvorgänge:<br />\n";
            echo implode("<br>", $lines);}
}
else
    {echo '<div style="color:#FF0000">'; echo "<br />\nDatei $filename gibt es gar nicht<br /></div>\n";}

?>
<br>
<?php
$relais = '48-Volt-System';
$filename = '/dev/shm/relais5_status.txt';
$anaus = '/media/platte/schuppendaten/strom_an_aus/zerow_an_aus_ch6_48V.txt';
if (file_exists($filename))
    {$inhalt = file_get_contents($filename);
    if (empty($inhalt))
        {echo '<div style="color:#FF0000">'; echo "<br />\nBitte warten sie, auf den Status vom $relais $inhalt<br /></div>\n";}
    else
        if (file_exists($anaus))
            $lines = file($anaus, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $lines = array_slice($lines, -4);
        if (is_numeric($inhalt) && ($inhalt == 2))
            {echo "<br />\n$relais ist an, letzte Schaltvorgänge:<br />\n";
            echo implode("<br>", $lines);}
        if (is_numeric($inhalt) && ($inhalt == 1))
            {echo "<br />\n$relais ist aus, letzte Schaltvorgänge:<br />\n";
            echo implode("<br>", $lines);}
}
else
    {echo '<div style="color:#FF0000">'; echo "<br />\nDatei $filename gibt es noch gar nicht<br /></div>\n";}

?>

<br><br>
<?php
$relais = '12-Volt-System';
$filename = '/dev/shm/relais1_status.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">'; echo "Bitte warten sie, auf den Status vom $relais $inhalt<br /></div>\n";}
    else
    if ($diffsek < 120)
    {echo "$relais wurde zuletzt vor $diffsek Sekunden geändert<br />\n";}
    else
    if ($diffmin < 120)
    {echo "$relais wurde zuletzt vor $diffmin Minuten geändert<br />\n";}
    else
    if ($diffstd < 48)
    {echo "$relais wurde seit $diffstd Stunden nicht geändert<br />\n";}
    else
    if ($tage > 1)
    {echo "$relais wurde seit $tage Tagen nicht geändert<br />\n";}
    else
    {echo '<div style="color:#FF0000">'; echo "Ungültiger Zeitstempel für $relais: $timestamp<br /></div>\n";}
?>

<?php
$relais = '24-Volt-System';
$filename = '/dev/shm/relais3_status.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">'; echo "Bitte warten sie, auf den Status vom $relais $inhalt<br /></div>\n";}
    else
    if ($diffsek < 120)
    {echo "$relais wurde zuletzt vor $diffsek Sekunden geändert<br />\n";}
    else
    if ($diffmin < 120)
    {echo "$relais wurde zuletzt vor $diffmin Minuten geändert<br />\n";}
    else
    if ($diffstd < 48)
    {echo "$relais wurde seit $diffstd Stunden nicht geändert<br />\n";}
    else
    if ($tage > 1)
    {echo "$relais wurde seit $tage Tagen nicht geändert<br />\n";}
    else
    {echo '<div style="color:#FF0000">'; echo "Ungültiger Zeitstempel: $timestamp<br /></div>\n";}
?>

<?php
$relais = '48-Volt-System';
$filename = '/dev/shm/relais5_status.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">'; echo "Bitte warten sie, auf den Status vom $relais $inhalt<br /></div>\n";}
    else
    if ($diffsek < 120)
    {echo "$relais wurde zuletzt vor $diffsek Sekunden geändert<br />\n";}
    else
    if ($diffmin < 120)
    {echo "$relais wurde zuletzt vor $diffmin Minuten geändert<br />\n";}
    else
    if ($diffstd < 48)
    {echo "$relais wurde seit $diffstd Stunden nicht geändert<br />\n";}
    else
    if ($tage > 1)
    {echo "$relais wurde seit $tage Tagen nicht geändert<br />\n";}
    else
    {echo '<div style="color:#FF0000">'; echo "Ungültiger Zeitstempel: $timestamp<br /></div>\n";}
?>
<br>
<?php
$filename = '/dev/shm/mcp3208_ch7.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">'; echo "<br />\nDatei für 12-Volt-Spannung existiert, ist aber leer oder Null: $inhalt<br /></div>\n";}
    else
    if ($diffsek < 60)
    {echo '<div style="color:#4CFF00">'; echo "12-Volt-System wurde zuletzt vor $diffsek Sekunden gemessen<br /></div>\n";}
    else
    if ($diffmin < 120)
    {echo '<div style="color:#4CFF00">'; echo "12-Volt-System wurde zuletzt vor $diffmin Minuten gemessen<br /></div>\n";}
    else
    if ($diffstd < 48)
    {echo '<div style="color:#FF0000">'; echo "12-Volt-System wurde seit $diffstd Stunden nicht gemessen<br /></div>\n";}
    else
    if ($tage > 1)
    {echo '<div style="color:#FF0000">'; echo "12-Volt-System wurde seit $tage Tagen nicht gemessen<br /></div>\n";}
    else
    {echo '<div style="color:#FF0000">'; echo "<br />\nUngültiger Zeitstempel<br /></div>\n";}
?>
<?php
$filename = '/dev/shm/mcp3208_ch5.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">'; echo "<br />\nDatei für 24-Volt-Spannung existiert, ist aber leer oder Null: $inhalt<br /></div>\n";}
    else
    if ($diffsek < 60)
    {echo '<div style="color:#4CFF00">'; echo "24-Volt-System wurde zuletzt vor $diffsek Sekunden gemessen<br /></div>\n";}
    else
    if ($diffmin < 120)
    {echo '<div style="color:#4CFF00">'; echo "24-Volt-System wurde zuletzt vor $diffmin Minuten gemessen<br /></div>\n";}
    else
    if ($diffstd < 48)
    {echo '<div style="color:#FF0000">'; echo "24-Volt-System wurde seit $diffstd Stunden nicht gemessen<br /></div>\n";}
    else
    if ($tage > 1)
    {echo '<div style="color:#FF0000">'; echo "24-Volt-System wurde seit $tage Tagen nicht gemessen<br /></div>\n";}
    else
    {echo '<div style="color:#FF0000">'; echo "<br />\nUngültiger Zeitstempel<br /></div>\n";}
?>
<?php
$filename = '/dev/shm/mcp3208_ch6.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">'; echo "<br />\nDatei für 48-Volt-Spannung existiert, ist aber leer oder Null: $inhalt<br /></div>\n";}
    else
    if ($diffsek < 60)
   {echo '<div style="color:#4CFF00">'; echo "48-Volt-System wurde zuletzt vor $diffsek Sekunden gemessen<br /></div>\n";}
    else
    if ($diffmin < 120)
    {echo '<div style="color:#4CFF00">'; echo "48-Volt-System wurde zuletzt vor $diffmin Minuten gemessen<br /></div>\n";}
    else
    if ($diffstd < 48)
    {echo '<div style="color:#FF0000">'; echo "48-Volt-System wurde seit $diffstd Stunden nicht gemessen<br /></div>\n";}
    else
    if ($tage > 1)
   {echo '<div style="color:#FF0000">'; echo "48-Volt-System wurde seit $tage Tagen nicht gemessen<br /></div>\n";}
    else
    {echo '<div style="color:#FF0000">'; echo "<br />\nUngültiger Zeitstempel<br /></div>\n";}
?>
<?php
$filename = '/dev/shm/temperatur.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
    $inhalt = file_get_contents($filename);
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">'; echo "<br />\nDatei für Temperatur existiert, ist aber leer oder Null: $inhalt<br /></div>\n";}
    else
    if ($diffmin < 60)
    {echo '<div style="color:#4CFF00">'; echo "<br />\nTemperatur $inhalt °C wurde zuletzt vor $diffmin Minuten gemessen<br /></div>\n";}
    else
    if ($diffstd < 48)
    {echo '<div style="color:#FF0000">'; echo "<br />\nTemperatur $inhalt °C wurde seit $diffstd Stunden nicht gemessen<br /></div>\n";}
    else
    if ($tage > 1)
    {echo '<div style="color:#FF0000">'; echo "<br />\nTemperatur $inhalt °C wurde seit $tage Tagen nicht gemessen<br /></div>\n";}
    else
    {echo '<div style="color:#FF0000">'; echo "<br />\nUngültiger Zeitstempel für Temperatur<br /></div>\n";}
?>

<?php
$filename = '/dev/shm/luftdruck.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
    $inhalt = file_get_contents($filename);
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">'; echo "<br />\nDatei für Luftdruck existiert, ist aber leer oder Null: $inhalt<br /></div>\n";}
    else
    if ($diffmin < 60)
    {echo '<div style="color:#4CFF00">'; echo "Luftdruck $inhalt hPa wurde zuletzt vor $diffmin Minuten gemessen</div>";}
    else
    if ($diffstd < 48)
    {echo '<div style="color:#FF0000">'; echo "Luftdruck $inhalt hPa wurde seit $diffstd Stunden nicht gemessen</div>";}
    else
    if ($tage > 1)
    {echo '<div style="color:#FF0000">'; echo "Luftdruck $inhalt hPa wurde seit $tage Tagen nicht gemessen</div>";}
    else
    {echo '<div style="color:#FF0000">'; echo "<br />\nUngültiger Zeitstempel für Luftdruck<br />\n</div>";}
?>
<?php
$filename = '/dev/shm/luftfeuchtigkeit.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
    $inhalt = file_get_contents($filename);
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">'; echo "<br />\nDatei für Luftfeuchtigkeit existiert, ist aber leer oder Null: $inhalt<br /></div>\n";}
    else
    if ($diffmin < 60)
    {echo '<div style="color:#4CFF00">'; echo "Luftfeuchtigkeit $inhalt % wurde zuletzt vor $diffmin Minuten gemessen</div>";}
    else
    if ($diffstd < 48)
    {echo '<div style="color:#FF0000">'; echo "Luftfeuchtigkeit $inhalt % wurde seit $diffstd Stunden nicht gemessen</div>";}
    else
    if ($tage > 1)
    {echo '<div style="color:#FF0000">'; echo "Luftfeuchtigkeit $inhalt % wurde seit $tage Tagen nicht gemessen</div>";}
    else
    {echo '<div style="color:#FF0000">'; echo "<br />\nUngültiger Zeitstempel für Luftfeuchtigkeit<br /></div>\n";}
?>
<?php
$filename = '/dev/shm/cputemp.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
{$inhalt = file_get_contents($filename);}
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">'; echo "Datei für CPU-Temperatur existiert, ist aber leer oder Null: $inhalt</div>";}
    else
    {echo "<br />\nDie CPU-Temperatur beträgt ";}
    if ($diffsek <= 120 and $inhalt >= 60)
    {echo '<div style="color:#FF0000">'; echo " $inhalt °C und wurde zuletzt vor $diffsek Sekunden gemessen<br /></div>\n";}
    else
    if ($diffmin >= 120 and $inhalt <= 60)
    {echo '<div style="color:#FF0000">'; echo " $inhalt °C aber wurde zuletzt vor $diffstd Stunden gemessen<br /></div>\n";}
    if ($diffmin >= 120 or $inhalt >= 60)
    {echo '<div style="color:#FF0000">'; echo " $inhalt °C und wurde zuletzt vor $diffmin Minuten gemessen<br /></div>\n";}
    else
    if ($diffsek <= 120 and $inhalt <= 60)
    {echo '<div style="color:#4CFF00">'; echo " $inhalt °C und wurde zuletzt vor $diffsek Sekunden gemessen<br /></div>\n";}
    else
    if ($diffsek >= 120 and $inhalt <= 60)
    {echo '<div style="color:#4CFF00">'; echo " $inhalt °C und wurde zuletzt vor $diffmin Minuten gemessen<br /></div>\n";}
    else
    {echo '<div style="color:#FF0000">'; echo "<br />\nUngültiger Dateiinhalt für CPU-Temperatur: $inhalt oder Zeit: $diffsek<br /></div>\n";}
?>
<br>
<?php
$filename = '/dev/shm/mcp3208_ch1.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
{
    $inhalt = file_get_contents($filename);
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">';  echo "<br />\nDatei für Betriebsspannung existiert, aber ist noch leer {$inhalt}<br /></div>\n"; }
    else
    if ($inhalt < 5.5 and $inhalt > 4.9 and $diffsek < 120)
    {echo 'Die Betriebsspannung beträgt <div style="color:#4CFF00">'; echo " $inhalt Volt und wurde zuletzt vor $diffsek Sekunden gemessen<br /></div>\n";}
    else
    if ($diffsek > 120 and $inhalt > 4.9)
    {echo '<div style="color:#4CFF00">'; echo "Die Betriebsspannung beträgt $inhalt Volt<br />\nund wurde zuletzt vor $diffmin Minuten gemessen<br /></div>\n";}
    else
    if ($diffmin < 120 and $inhalt > 5)
    {echo '<div style="color:#4CFF00">'; echo "Die Betriebsspannung beträgt $inhalt Volt<br />\nund wurde zuletzt vor $diffmin Minuten gemessen<br /></div>\n";}
    else
    if ($diffstd < 48)
    {echo '<div style="color:#FF0000">'; echo "Die Betriebsspannung beträgt $inhalt Volt<br />\n, aber wurde seit $diffstd Stunden nicht gemessen<br /></div>\n";}
    else
    if ($tage > 1)
    {echo '<div style="color:#FF0000">'; echo "Die Betriebsspannung beträgt $inhalt Volt<br />\n, aber wurde seit $tage Tagen nicht gemessen<br /></div>\n";}
    else
    {echo '<div style="color:#FF0000">'; echo "<br />\nUngültiger Dateiinhalt: $inhalt<br /></div>\n";}
}
else
{
    echo '<div style="color:#FF0000">'; echo "Datei $filename gibt es gar nicht<br /></div>\n";
}
?>
<br>
<?php
$filename = '/dev/shm/mcp3208_ch0.txt';
$diffsek = abs(date(filemtime($filename))-$timestamp);
$diffmin = floor($diffsek/60);
$diffstd = floor($diffmin/60);
$tage = floor($diffstd/24);
if (file_exists($filename))
{
    $inhalt = file_get_contents($filename);
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">';  echo "<br />\nDatei für Referenzspannung existiert, aber ist noch leer {$inhalt}<br /></div>\n"; }
    else
    if ($diffsek < 120 and $inhalt < 3.0 and $inhalt >3.4)
    {echo 'Die Referenzspannung beträgt <div style="color:#4CFF00">'; echo " $inhalt Volt und wurde zuletzt vor $diffsek Sekunden gemessen<br /></div>\n";}
    else
    if ($diffsek < 120 and $inhalt >=3.3)
    {echo 'Die Referenzspannung beträgt <div style="color:#4CFF00">'; echo " $inhalt Volt und wurde zuletzt vor $diffsek Sekunden gemessen<br /></div>\n";}
    else
    if ($diffmin < 120 and $inhalt >=3.3)
    {echo 'Die Referenzspannung beträgt <div style="color:#4CFF00">'; echo " $inhalt Volt und wurde zuletzt vor $diffmin Minuten gemessen<br /></div>\n";}
    else
    if ($diffstd < 48)
    {echo '<div style="color:#FF0000">'; echo "Die Referenzspannung beträgt $inhalt Volt<br />\n, aber wurde seit $diffstd Stunden nicht gemessen<br /></div>\n";}
    else
    if ($tage > 1)
    {echo '<div style="color:#FF0000">'; echo "Die Referenzspannung beträgt $inhalt Volt<br />\n, aber wurde seit $tage Tagen nicht gemessen<br /></div>\n";}
    else
    {echo '<div style="color:#FF0000">'; echo "<br />\nUngültiger Dateiinhalt: $inhalt<br /></div>\n";}
}
else
{
    echo '<div style="color:#FF0000">'; echo "Datei $filename gibt es gar nicht<br /></div>\n";
}
?>
<br>
<?php
$filename = '/dev/shm/wttr.txt';
if (file_exists($filename))
{
    $inhalt = file_get_contents($filename);
    if (empty($inhalt))
    {echo '<div style="color:#FF0000">';  echo "<br />\n{$inhalt}<br /></div>\n"; }
    else
    {echo "$inhalt<br /></div>\n";}
}
?>
<br>
</font>
</html>
