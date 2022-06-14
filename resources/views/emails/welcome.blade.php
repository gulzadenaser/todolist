<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
Hello,
<br />
<h3>Thank you very much for the registration on our website {{$user['name']}}</h3>
<br/>
    Your have registered email-id is {{$user['email']}}
<br />
    Your temporary password to login the system is: <b> {{ $randomPassword }}</b>

    <br />
    <br />
    Yours sincerly,<br />
    System Email
</body>

</html>