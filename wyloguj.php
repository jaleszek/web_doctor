<?php
session_start();
session_unset();
session_destroy();

echo "<script>alert('Dzi�kujemy za skorzystanie z systemu Holter monitor');</script>";
echo "<script>location.href='ekg_opis.html'</script>";
?>