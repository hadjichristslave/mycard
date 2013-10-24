<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>New message from web-site</h2>
 
        <div>
            Message details:
        </div>
        <div>User :   {{ $name}}</div>
        <div>Email:   {{ $email}} </div>
        <div>Message: {{ $content}} </div>
		<div style="margin:50px 0 0 50%;color:red;font-size:20px;"> <i>Mail Sent from {{$ip}}</i></div>
    </body>
</html>