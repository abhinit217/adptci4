<!doctype html>
<html>
<head>
   <title>Home Page</title>

   <!-- CSS file -->
   <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
   <h2><?= $content; ?></h2>
   <table>
     <tr>
        <td>Name : </td>
        <td><input type='text' /></td>
     </tr>
     <tr>
        <td>Username : </td>
        <td><input type='text' /></td>
     </tr>
     <tr>
        <td>Email : </td>
        <td><input type='text' /></td>
     </tr>
     <tr>
        <td>&nbsp;</td>
        <td><input type='button' value='Submit' /></td>
     </tr>
   </table>
</body>
</html>