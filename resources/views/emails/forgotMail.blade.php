<!DOCTYPE html>
<html>
<head>
    <title>Jewelxy</title>
</head>
<body>
    <h1>Welcome To Jewelxy</h1>
    <h4>To reset Your Password Click on Below link.</h4>
    <p><a href="{{ route('reset.pass.store.view', ['token' => $token]) }}" class="common-btn12">Change Password</a></p>
    <p>Thank you</p>
</body>
</html>