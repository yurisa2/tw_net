<!DOCTYPE html>
<html>
<body>

<form action="send_file_be.php" method="post" enctype="multipart/form-data">
    Set Name
    <p><input type="text" name="set" id="set"></p>
    Select file to upload:
    <p><input type="file" name="fileToUpload" id="fileToUpload"></p>
    <input type="submit" value="Send File" name="submit">
</form>

</body>
</html>
