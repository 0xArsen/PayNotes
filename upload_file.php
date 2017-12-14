<head>
<title>Submit Note </title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="style.css" rel="stylehsheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" />
<style>
.mc-up{
  margin-top: 10%;
 margin-left:30%;
  line-height: 2em;
  color: white;
}
input{
color: black;
}
body{
background-color: #3E8EDE;
}
</style>
</head>

<div class="mc-up slideInUp animated">
<h1> Hello Note Taker </h1>
<form action="email_requester.php" method="post" enctype="multipart/form-data">
   Enter Note ID: <br/>
   <input type="number" name="ID" id="idof">
   <br/>
   Enter PayPal public link:<br/> 
   <input type="text" name="paypal_link" id="paypal"><br/>
    Upload File:
    <input type="hidden" name="e_type" value= 2>
    <input type="file" name="fileToUpload" id="fileToUpload"><br/>
    <input type="submit" class="btn btn-success" value="Upload File" name="submit">
</form>
</div>
