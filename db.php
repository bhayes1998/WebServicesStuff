<?php
$conn = mysqli_connect("ceclnx01.csi.miamioh.edu","exam","password","exam");
$result = mysqli_query($conn,"SELECT * FROM test");
$count  = mysqli_num_rows($result);
if ($count > 0) {
        while($row = mysql_fetch_array($result)) {
		echo $row['user'];
	}
}
?>
<html>
<body>
	<?php echo $row['user']; ?>
</body>
</html>
