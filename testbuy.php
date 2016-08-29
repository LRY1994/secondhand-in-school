<?php
session_start();
echo $_SESSION['userID'];
echo "<br/>";
echo $_SESSION['name'];
echo "<br/>";
echo $_COOKIE['username'];
echo "<br/>";
